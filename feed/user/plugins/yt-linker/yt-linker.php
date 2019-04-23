<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class YtLinkerPlugin
 * @package Grav\Plugin
 */
class YtLinkerPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        $uri = $this->grav['uri'];
        $route = $this->config->get('plugins.yt-linker.route');

        if ($route && $route == $uri->path()) {
          $this->grav['output'] = $this->doJsonMagic();
        }
    }

    function doJsonMagic() { 
      $downloader = new YouTubeDownloader();

      if (isset($_GET["id"])) {
        $downloader->setUrl('url=https://www.youtube.com/watch?v='.$_GET['id']);

        echo json_encode($downloader->getVideoDownloadLink());
      } else {
        echo json_encode(false);
      }
    } 
}

class YouTubeDownloader {
  /*
   * Video Id for the given url
   */
  private $video_id;
   
  /*
   * Video title for the given video
   */
  private $video_title;
   
  /*
   * Full URL of the video
   */
  private $video_url;
  
  /*
   * store the url pattern and corresponding downloader object
   * @var array
   */
  private $link_pattern;
  
  public function __construct(){
      $this->link_pattern = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed)\/))([^\?&\"'>]+)/";
  }
  
  /*
   * Set the url
   * @param string
   */
  public function setUrl($url){
      $this->video_url = $url;
  }
  
  /*
   * Get the video information
   * return string
   */
  private function getVideoInfo(){
      return file_get_contents("https://www.youtube.com/get_video_info?video_id=".$this->extractVideoId($this->video_url)."&cpn=CouQulsSRICzWn5E&eurl&el=adunit");
  }
   
  /*
   * Get video Id
   * @param string
   * return string
   */
  private function extractVideoId($video_url){
      //parse the url
      $parsed_url = parse_url($video_url);
      if($parsed_url["path"] == "youtube.com/watch"){
          $this->video_url = "https://www.".$video_url;
      }elseif($parsed_url["path"] == "www.youtube.com/watch"){
          $this->video_url = "https://".$video_url;
      }
      
      if(isset($parsed_url["query"])){
          $query_string = $parsed_url["query"];
          //parse the string separated by '&' to array
          parse_str($query_string, $query_arr);
          if(isset($query_arr["v"])){
              return $query_arr["v"];
          }
      }   
  }
  
  /*
   * Get the downloader object if pattern matches else return false
   * @param string
   * return object or bool
   * 
   */
  public function getDownloader($url){
      /*
       * check the pattern match with the given video url
       */
      if(preg_match($this->link_pattern, $url)){
          return $this;
      }
      return false;
  }
   
  /*
   * Get the video download link
   * return array
   */
  public function getVideoDownloadLink(){
      //parse the string separated by '&' to array
      parse_str($this->getVideoInfo(), $data);
      
      if ($data['status'] === 'ok') {

        //set video title
        $this->video_title = $data["title"];
        
        //Get the youtube root link that contains video information
        $stream_map_arr = $this->getStreamArray();
        $final_stream_map_arr = array();
        
        //Create array containing the detail of video 
        foreach($stream_map_arr as $stream){
          parse_str($stream, $stream_data);
          $stream_data["title"] = $this->video_title;
          $stream_data["mime"] = $stream_data["type"];
          $mime_type = explode(";", $stream_data["mime"]);
          $stream_data["mime"] = $mime_type[0];
          $start = stripos($mime_type[0], "/");
          $format = ltrim(substr($mime_type[0], $start), "/");
          $stream_data["format"] = $format;
          unset($stream_data["type"]);
          $final_stream_map_arr [] = $stream_data;         
        }
        return $final_stream_map_arr;
      } else {
        return false;
      }
  }
   
  /*
   * Get the youtube root data that contains the video information
   * return array
   */
  private function getStreamArray(){
      parse_str($this->getVideoInfo(), $data);
      $stream_link = $data["url_encoded_fmt_stream_map"];
      return explode(",", $stream_link); 
  }
   
  /*
   * Validate the given video url
   * return bool
   */
  public function hasVideo(){
      $valid = true;
      parse_str($this->getVideoInfo(), $data);
      if($data["status"] == "fail"){
          $valid = false;
      } 
      return $valid;
  }
}