<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\OtherController;

use Modules\Srs\Http\Controllers\OsintInstagramController;
use Modules\Srs\Http\Controllers\OsintTiktokController;

use AuthHelper;
use FormHelper;

class OsintProfileController extends Controller
{
    private static $moduleCode = 'SRSOSI';
    
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function search(Request $req) 
    {
      $validator = Validator::make($req->all(), [
        'keyword_profile' => 'required',
      ]);

      if ($validator->fails())
      {
        echo 'Form tidak sesuai';
      }
      else
      {
        $keyword = $req->input('keyword_profile');

        $html = '';
        try {
            // $ig = self::getInstagram($keyword);
            $ig = (new OsintInstagramController)->reqUrl($keyword);
            // $ig = (new OsintInstagramController)->jsonRes($keyword);

            // $tiktok = self::getTiktok($keyword);
            $tk = (new OsintTiktokController)->userInfo($keyword);
            $tkVideo = (new OsintTiktokController)->userPost($keyword);

            // $getEmail = self::getEmail($keyword);
            // $html .= self::getAllPlatformRapid($keyword,'all');
        } catch (Exception $e) {
            $html .= 'Caught exception: ,'.  $e->getMessage(). "\n";
        }

        // dd($ig->content);

        $phone = $email = $image = $username = $fullName = $bio = '-';

        if($ig->status == '000')
        {
          $email = $ig->content->data->user->business_email;
          $phone = $ig->content->data->user->business_phone_number;
          $address = $ig->content->data->user->business_address_json;
          $image = $ig->content->data->user->profile_pic_url_hd;
          $username = $ig->content->data->user->username;
          $fullName = $ig->content->data->user->full_name;
          $bio = $ig->content->data->user->biography;
          $media = $ig->content->data->user->edge_owner_to_timeline_media->edges;
          $imgencode = base64_encode(file_get_contents($image));
          $image = ' <img src="data:image/png;base64,'.$imgencode.'" alt="avatar"
          class="img-fluid" style="height: 150px;">';
        }
        if(isset($getEmail->data->status) && ($email !== '-' || $email == null)) {
          $email = $getEmail->data->status == 'valid' ? $getEmail->data->email : '-';
        }

        // TIKTOK //
        // if($tk->status == '000' && $tk->content->success)
        // if(isset($tk->tkStatusUser) && $tk->tkStatusUser)
        // {
        //   $tkStatus = true;
        //   $tkUsername = $tk->content->data->user->uniqueId;
        // }

        $html .= '<section id="searchResultProfile" class="text-white">
        <div class="container py-5">
          <div class="row">
            <div class="col-lg-4">
              <div class="card mb-4">
                <div class="card-body text-center">
                  '.$image.'
                  <h5 class="my-3">'.$username.'</h5>
                  <!--<p class="mb-1">Example</p>-->
                  <p class="mb-4">'.$bio.'</p>
                  <!--<div class="d-flex justify-content-center mb-2">
                    <button type="button" class="btn btn-primary">Follow</button>
                    <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                  </div>-->
                </div>
              </div>
              
              <div class="card mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Full Name</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="mb-0">'.$fullName.'</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="mb-0">'.$email.'</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Phone</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="mb-0">'.(empty($phone) ? '-' : $phone).'</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Address</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="mb-0">'.(empty($addres) ? '-' : $addres).'</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-4 mb-lg-0">
                <div class="card-body p-0">
                  <ul class="list-group list-group-flush rounded-3">
                    <!--<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-globe fa-lg text-warning"></i>
                      <p class="mb-0">https://mdbootstrap.com</p>
                    </li>-->
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fab fa-instagram fa-lg" style="color: #ffffff;"></i>
                      <p class="mb-0">'.$keyword.'</p>
                    </li>';
                    // $html .= '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    //   <i class="fab fa-facebook-f fa-lg" style="color: #ffffff;"></i>
                    //   <p class="mb-0">mdbootstrap</p>
                    // </li>';
                    if(isset($tk->tkStatusUser) && $tk->tkStatusUser) {
                      $html .= '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fab fa-tiktok fa-lg" style="color: #ffffff;"></i>
                        <a href="https://www.tiktok.com/@'.$tk->tkUserName.'"><p class="mb-0">@'.$tk->tkUserName.'</p></a>
                      </li>';
                    }
                    // $html .= '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    //   <i class="fab fa-twitter fa-lg" style="color: #ffffff;"></i>
                    //   <p class="mb-0">@mdbootstrap</p>
                    // </li>';
                    $html .= '</ul>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="row mb-5">
                <div class="col-12 text-center mb-3"><h1 class="h3">INSTAGRAM POST</h1></div>';
                if($ig->status == '000' && isset($media))
                {
                  $html .= '<div class="col-12">
                  <div class="card-columns">';
                  $i = 0;
                  foreach ($media as $key => $mda) {
                    // if($mda->node->__typename == 'GraphImage' || $mda->node->__typename == 'GraphSidecar')
                    // {
                      $getImage = base64_encode(file_get_contents($mda->node->display_url));
                      $mediaType = '<img class="card-img-top" src="data:image/png;base64,'.$getImage.'" alt="Card image cap">';
                    // }
                    // if($mda->node->__typename == 'GraphVideo')
                    $caption = isset($mda->node->edge_media_to_caption->edges) && !empty($mda->node->edge_media_to_caption->edges) ?$mda->node->edge_media_to_caption->edges[0]->node->text : '-';

                    $html .= '
                        <div class="card">
                          '.$mediaType.'
                          <div class="card-body">
                            <p class="card-text text-expand">'.$caption.'</p>
                            <button type="button" class="read-more btn btn-primary btn-sm float-right">Read More</button>
                            <p class="card-text"><small class="badge badge-info">INSTAGRAM</small></p>
                          </div>
                        </div>';
                    $i++;
                    if($i==6) break;
                  }
                  $html .= '</div></div>';
                }
                $html .= '</div>';
                
              $html .= '
                  <div class="row">
                    <div class="col-12 text-center mb-3"><h1 class="h3">TIKTOK POST</h1></div>';
              $html .= '</div>';
              
              if(isset($tkVideo->tkStatusVideo) && $tkVideo->tkStatusVideo)
              {
                $html .= '<div class="col-12">
                <div class="card-columns">';
                $i = 0;
                foreach ($tkVideo->videos as $key => $tim) {
                  $urlVideo = $tim->cover;
                  // $getImage = base64_encode(file_get_contents($urlVideo));
                  // $mediaType = '<a href="https://www.tiktok.com/@'.$tim->title.'/video/'.$tim->video_id.'" target="_blank"><img class="card-img-top" src="data:image/png;base64,'.$getImage.'" alt="Card image cap"></a>';
                  $mediaType = '<a href="https://www.tiktok.com/@'.$tim->title.'/video/'.$tim->video_id.'" target="_blank"><img class="card-img-top" src="'.$urlVideo.'" alt="Card image cap"></a>';

                  $html .= '
                      <div class="card">
                        '.$mediaType.'
                        <div class="card-body">
                          <p class="card-text">'.$tim->title.'</p>
                          <p class="card-text"><small class="">'.gmdate("Y-m-d H:i:s",$tim->create_time).'</small></p>
                          <p class="card-text"><small class="badge badge-info">TIKTOK</small></p>
                        </div>
                      </div>';
                  $i++;
                  if($i==20) break;
                }
                $html .= '</div></div>';
              }

              $html .= '</div>
          </div>
        </div>
        </section>';

        echo $html;
      }
    }

    public function searchTest() 
    {
        $urlSosmed = array(
            'https://www.tiktok.com/@',
            'https://www.instagram.com/', 
            'https://www.facebook.com/',
        );

        $keyword = 'kliniksecurity';
        // $url = 'https://bibliogram.art/u/';
        // $url = "https://www.instagram.com/";
        // $url = "https://www.tiktok.com/@{$keyword}";

        // $ig = (new OsintInstagramController)->reqUrl($keyword);
        // $ig = (new OsintInstagramController)->jsonRes($keyword);
        // $media = $ig->content->data->user->edge_owner_to_timeline_media->edges;
        // foreach ($media as $key => $mda) {
        //   $image = base64_encode(file_get_contents($mda->node->display_url));
        //   // echo '<img src="data:image/png;base64,'.$image.'" alt="media"><br>';
        // }
        // echo json_encode($media,true); 

        $tk = (new OsintTiktokController)->userInfo($keyword);
        // $tkVideo = (new OsintTiktokController)->userVideo($keyword);
        
        echo json_encode($tk, true);
        die;
        // foreach ($tk->content->data->items as $key => $tim) {
        //   // $image = base64_encode(file_get_contents($mda->node->display_url));
        //   // echo '<img src="data:image/png;base64,'.$image.'" alt="media"><br>';
        //   echo '<img src="'.$tim->video->cover.'" alt="media"><br>';
        // }
        
        $urlRapidUsername = "https://check-username.p.rapidapi.com/check/instagram/$keyword";
        // $reqRapid = self::reqRapid($urlRapidUsername);
        
        // $req = self::getAllPlatformRapid($keyword,'all');

        // $ig = self::getInstagram($keyword);
        // $urlImg = $ig->data->graphql->user->profile_pic_url_hd;
        
        // $tiktok = self::getTiktok($keyword);
        $email = self::getEmail($keyword);
        // $content->data->status == 'valid'

        dd($email);

        $content = file_get_contents($urlImg);
        header('Content-type: image/jpeg');
        echo $content;
      
        echo '<img src="'.$urlImg.'" alt="avatar"
        class="img-fluid" style="height: 150px;">';
        die();

        // $keyword = 'taylor%2Bswift';
        // $req = self::getGoogle($keyword);

        $html = '<div id="searchResultProfile" class="row px-2 mt-4 mb-1">';
            echo self::getInstagram($keyword);
            // echo self::getTiktok($keyword);
            // echo self::getEmail($keyword);
        $html .= '</div>';

        echo $html;
        die;

        // $words = str_word_count($keyword, 1);
        // shuffle($words);
        // $selection = array_slice($words, 0, 5);

        // $request = @file_get_contents($url);
        // preg_match('/([0-9])\d+/',$http_response_header[0],$matches);
        // $responsecode = intval($matches[0]);
        // echo $responsecode;

        // $headers = get_headers($url);
        // return substr($headers[0], 9, 3);
        // foreach ($get_http_response_code as $gethead) { 
        //     if ($gethead == 200) {
        //         echo "OKAY!";
        //     } else {
        //         echo "Nokay!";
        //     }
        // }
    }

    private function getInstagram($keyword)
    {
        $urlReq = "https://www.instagram.com/{$keyword}/?__a=1&__d=dis";
        $urlEnd = 'https://www.instagram.com/';

        // $dataJson = json_decode($rawJson);
        
        // $res = self::reqUrlProxy($urlReq);
        $res = self::reqUrl($urlReq);
        // $res = self::reqInstagram($urlReq);
        // $dataJson = json_decode($res['content']);

        // dd($res->data->user->biography);

        $res = [
            'http_code' => 404,
            'msg' => 'not found'
        ];

        if(isset($dataJson->status) && $dataJson->status == 'fail')
        {
            $res = [
                'http_code' => 500,
                'msg' => $dataJson->message
            ];
        }

        if(isset($dataJson->logging_page_id) && !empty($dataJson->logging_page_id))
        {
            $res = [
                'http_code' => 200,
                'msg' => 'success',
                'data' => $dataJson
            ];
        }

        $data = (object) $res;
        
        $html = '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= $data->http_code == 200 ? '<a href="'.$urlEnd.$keyword.'" target="_blank">' : '';
        $html .= '<h5 class="card-title">Instagram</h5>';
        $html .= $data->http_code == 200 ? '</a>' : '';
        $html .= '<p class="card-text text-white">'.self::convResponseCode($data->http_code).'</p>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $data;
    }

    private function getTiktok($keyword)
    {
        $urlReq = "https://www.tiktok.com/@{$keyword}";
        $urlEnd = "https://www.tiktok.com/@{$keyword}";
        
        $res = self::reqUrl($urlReq);
        $res = json_decode (json_encode ($res), FALSE);

        $html = '<div class="card">';
        $html .= '<div class="card-body">';
            $res->header->http_code == '200' ? $html .= '<a href="'.$urlEnd.'" target="_blank">' : '';
            $html .= '<h5 class="card-title">Tiktok</h5>';
            $res->header->http_code == '200' ? $html .= '</a>' : '';
            $html .= '<p class="card-text text-white">'.self::convResponseCode($res->header->http_code).'</p>';
        $html .= '</div>';
        $html .= '</div>';

        return $res;
    }

    private function getEmail($keyword)
    {
        $keyword = $keyword.'@gmail.com';
        $apiKey = '9e8001fb05b956036ae9d14c69b3913450b4a323';
        $urlReq = "https://api.hunter.io/v2/email-verifier?email={$keyword}&api_key={$apiKey}";
        $urlEnd = "";
        
        $res = self::reqUrl($urlReq);

        $status = 'Tidak ditemukan';
        $content = json_decode($res['content']);
        
        if(!isset($content->errors))
        {
            // $content = json_decode($res['content']);
            // var_dump($content->data->status);die;
            
            if($content->data->status == 'valid') $status = 'Ditemukan';
        }

        $html = '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">Email: '.$keyword.'</h5>';
        $html .= '<p class="card-text text-white">'.$status.'</p>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $content;
    }
    
    private function getAllPlatformRapid($keyword)
    {
        $apiKey = '9e8001fb05b956036ae9d14c69b3913450b4a323';
        $urlReq = "https://check-username.p.rapidapi.com/check/$keyword";
        $urlEnd = "";
        
        $res = self::reqRapid($urlReq);
        
        $res = '{
            "success": true,
            "username": "username",
            "instagram": true,
            "facebook": true,
            "tiktok": true,
            "pinterest": false,
            "github": false,
            "reddit": false,
            "steam": false,
            "twitch": false,
            "medium": false,
            "minecraft": false,
            "patreon": false,
            "etsy": false,
            "soundcloud": false,
            "linktree": false,
            "9gag": false,
            "ask.fm": false,
            "dockerhub": false,
            "tumblr": false,
            "wikipedia": false,
            "dev.to": false,
            "shopify": false,
            "snapchat": false,
            "vimeo": false,
            "behence": false,
            "dribbble": false
          }';

        $status = 'Tidak ditemukan';
        $content = json_decode($res);
        
        if(!isset($content->success))
        {   
            if($content->success) $status = 'Ditemukan';
        }
        
        $html = '';
        foreach ($content as $key => $plt) {
            if($key !== 'success' && $key !== 'username') 
            {
                $html .= '<div class="card">';
                // <img class="card-img-top" src="..." alt="Card image cap">
                $html .= '<div class="card-body">';
                $html .= '<h5 class="card-title">'.ucfirst($key).'</h5>';
                $html .= '<p class="card-text">'.self::convResponseCode($plt).'</p>';
                $html .= '</div>';
                $html .= '</div>';

                // $html .= '<div class="col-12 p-2">';
                //     $html .= '<h3>'.$key.'</h3>';
                //     $html .= '<h5>Username: '.$keyword.'</h5>';
                //     $html .= '<p class="text-white">'.self::convResponseCode($plt).'</p>';
                // $html .= '</div>';
            }
        }
        // $html .= '</div>';
        
        return $html;
    }

    private function getGoogle($keyword)
    {
        $apiKey = 'AIzaSyAC_jRtQ1XkRi_YaIHqQyYEixk8lU9rv3g';
        $apiLimit = 10;
        $urlReq = "https://kgsearch.googleapis.com/v1/entities:search?query=$keyword&key=$apiKey&limit=$apiLimit&indent=True";
        
        $res = self::reqUrl($urlReq);
        $res = $res['content'];
        return $res;
    }
    
    private function reqInstagram($keyword)
    {
      $api="https://i.instagram.com/api/v1/users/web_profile_info/?username=$keyword";
      $header="User-Agent':'Instagram 76.0.0.15.395 Android (24/7.0; 640dpi; 1440x2560; samsung; SM-G930F; herolte; samsungexynos8890; en_US; 138226743)";
      $ch = curl_init($api);
      curl_setopt($ch, CURLOPT_USERAGENT, $header);
      curl_setopt($ch, CURLOPT_REFERER, 'https://www.instagram.com/');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("x-ig-app-id: 567067343352427"));
      $result = curl_exec($ch);
      curl_close($ch);
      $result=json_decode($result);
      $status=$result->status;

      // var_dump($result);die;

      if ($status=="ok")
      {
        $res = [
          'status' => '000',
          'content' => $result
        ];
        // $username=$result->data->user->username;
        // $fullname=$result->data->user->full_name;
        // $isprivate=$result->data->user->is_private;

        // if ($isprivate==TRUE)
        // {
        //     $isprivate="True";
        // }
        // else
        // {
        //     $isprivate="No";
        // }



        // $isverified=$result->data->user->is_verified;

        // if ($isverified==TRUE)
        // {
        //     $isverified="Yes";
        // }
        // else
        // {
        //     $isverified="No";
        // }

        // $url=$result->data->user->external_url;
        // if ($url=="")
        // {
        //     $url="No URL";
        // }

        // $biography=$result->data->user->biography;
        // if ($biography=="")
        // {
        //     $biography="No Biography";
        // }
        // $followercount=$result->data->user->edge_followed_by->count;
        // $followingcount=$result->data->user->edge_follow->count;
        // $totalpost=$result->data->user->edge_owner_to_timeline_media->count;

        // $dp_hd=$result->data->user->profile_pic_url_hd;
        // $dp=$result->data->user->profile_pic_url;
        // echo "Name : <b>". $fullname."</b><br>";
        // echo "Username :  <b>"."<a href='https://instagram.com/$username'>$username</a>"." </b><br>";
        // echo "BioGraphy : <b>". $biography."</b><br>";
        // echo "URL : <b>". "<a href='$url'>$url</a>"."</b><br>";
        // echo "Is Verified Account : <b>". $isverified."</b><br>";
        // echo "Is Private Account <b>: ". $isprivate."</b><br>";
        // echo "Total Posts : <b>". $totalpost."</b><br>";
        // echo "Total Followers : <b>". $followercount."</b><br>";
        // echo "Total Following : <b>". $followingcount."</b><br>";
        // echo "DP : <b><a href='$dp_hd'>High Quality</a> | <a href='$dp'>Normal Quality</a></b><br>";

      }
      else
      {
        $res = [
          'status' => '001',
        ];
      }
      $res = (object) $res;
      
      return $res;
    }
    
    private function reqUrl($url, $method='', $field='')
    {
        $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/50.0.2661.102 Chrome/50.0.2661.102 Safari/537.36';

        $options = array(
            // CURLOPT_CUSTOMREQUEST  => "GET",        //set request type post or get
            // CURLOPT_POST           => false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "gzip",   // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_COOKIESESSION => true, //Enable cookie session
            CURLOPT_VERBOSE => false,
        );
        
        $ch = curl_init($url);
        curl_setopt_array( $ch, $options );
        
        $proxies = array(); //Declaring an array to store the proxy list
        //Adding list of proxies to the $proxies array
        // $proxies[] = 'user:password@173.234.11.134:54253'; //Some proxies require user, password, IP and port number
        $proxies[] = '173.234.92.107'; //Some proxies only require IP
        // $proxies[] = '173.234.94.90:54253'; //Some proxies require IP and port number

        //Choose a random proxy from our proxy list
        // if(isset($proxies)){
        //   $proxy = $proxies[array_rand($proxies)]; //Select a random proxy from the array and assign to $proxy variable
        // }
        // if(isset($proxy)){
        //   curl_setopt($ch, CURLOPT_PROXY, $proxy); //Set CURLOPT_PROXY with proxy in $proxy variable
        // }

        // curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$PROXY_USER:$PROXY_PASS");
        // curl_setopt($ch, CURLOPT_PROXY, "https://$PROXY_HOST:$PROXY_PORT");
        
        if($method !=='' && $method == 'post') 
        {
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        }
        else
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }
        $content = curl_exec( $ch );
        $err = curl_errno( $ch );
        $errmsg = curl_error( $ch );
        $header = curl_getinfo( $ch );
        curl_close($ch);

        // $header['errno']   = $err;
        // $header['errmsg']  = $errmsg;

        return [ 
            'header' => $header,
            'content' => $content
        ];
    }
    
    private function reqUrlProxy($url, $method='', $field='')
    {
      // $url = 'http://example.com/example-post/';
      $ip  = '1.1.1.1'; // trying to spoof ip..

      $header[0]  = "Accept: text/xml,application/xml,application/xhtml+xml,"; 
      $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";

      $header[] = "Cache-Control: max-age=0"; 
      $header[] = "Connection: keep-alive"; 
      $header[] = "Keep-Alive: 300"; 
      $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; 
      $header[] = "Accept-Language: en-us,en;q=0.5"; 
      $header[] = "Pragma: "; // browsers = blank
      $header[] = "X_FORWARDED_FOR: " . $ip;
      $header[] = "REMOTE_ADDR: " . $ip;
      $header[] = "Host: example.com";

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
      curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
      curl_setopt($curl, CURLOPT_HEADER, false); 
      curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com'); 
      curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate'); 
      curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
      curl_setopt($curl, CURLOPT_VERBOSE, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie.txt"); 
      curl_setopt($curl, CURLOPT_COOKIEJAR, "cookie.txt");
      curl_setopt($curl, CURLOPT_COOKIESESSION, true); 

      $response = curl_exec($curl);

      dd($response);

      if ($response === false) {
        
        die('Error '. curl_errno($curl) .': '. curl_error($curl));
        
      } else {
        
        echo '<div>';
        print_r($response);	
        echo '</div>';
        echo '<br><br>';
        echo '<div>' . urldecode($url) . '</div>';
        
      }

      curl_close($curl);
    }

    public function reqRapid($url) 
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: check-username.p.rapidapi.com",
                "X-RapidAPI-Key: f1b580a982mshdda8208830c1a51p10d042jsn33152d557a3d"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // if ($err) 
        // {
        //     return [
        //         'content' => "cURL Error #:" . $err
        //     ];
        // }

        return $response;
    }

    public function searchLoop(Request $req) {
        $validator = Validator::make($req->all(), [
            'keyword_profile' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo 'Form tidak sesuai';
        }
        else
        {
            $urlSosmed = array(
                'https://www.tiktok.com/@',
                'https://www.instagram.com/', 
                'https://www.facebook.com/',
            );
            $keyword = $req->input('keyword_profile');

            $html = '<div id="searchResultProfile" class="row px-2 mt-4 mb-1">';
            foreach ($urlSosmed as $key => $url) {
                $html .= '<div class="col-12 p-2">';
                try {
                    $res = self::getUrl($url.$keyword);
                    $html .= '<a href="'.$url.$keyword.'" target="_blank">'.$url.$keyword.' - '.self::convResponseCode($res['http_code']).'</a>';
                    // echo http_response_code();
                } catch (Exception $e) {
                    $html .= 'Caught exception: ,'.  $e->getMessage(). "\n";
                }
                $html .= '</div>';
            }
            $html .= '</div>';
    
            echo $html;
        }
    }

    private function getUrl($url)
    {
        $ch = curl_init();
        $arrSetHeaders = array(
            "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/50.0.2661.102 Chrome/50.0.2661.102 Safari/537.36",
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: deflate, br',
            'Connection: keep-alive',
            'cache-control: max-age=0',
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrSetHeaders);   
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/50.0.2661.102 Chrome/50.0.2661.102 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        // $cookie = "osintprofile.txt";
        // curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/".$cookie);
        // curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/".$cookie);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $exec = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        // echo $url.' - '.$info["http_code"];
        // echo "<pre>";
        // print_r($info);

        return $info;
        // return array(
        //     'code' => $info["http_code"]
        // );
    }

    private function instagramLoginTest()
    {
        $USERNAME = "ridho.sistem.adm";
        $PASSWORD = "Xef#bwsru$95";
        $USERAGENT = "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36";
        $COOKIE = $USERNAME.".txt";

        @unlink(dirname(__FILE__)."/!instagram/".$COOKIE);

        $url="https://www.instagram.com/accounts/login/?force_classic_login";

        $ch  = curl_init(); 

        $arrSetHeaders = array(
            "User-Agent: $USERAGENT",
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: deflate, br',
            'Connection: keep-alive',
            'cache-control: max-age=0',
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrSetHeaders);         
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/!instagram/".$COOKIE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/!instagram/".$COOKIE);
        curl_setopt($ch, CURLOPT_USERAGENT, $USERAGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $page = curl_exec($ch);
        curl_close($ch);  

        //var_dump($page);

        // try to find the actual login form
        if (!preg_match('/<form method="POST" id="login-form" class="adjacent".*?<\/form>/is', $page, $form)) {
            die('Failed to find log in form!');
        }

        $form = $form[0];

        // find the action of the login form
        if (!preg_match('/action="([^"]+)"/i', $form, $action)) {
            die('Failed to find login form url');
        }

        $url2 = $action[1]; // this is our new post url
        // find all hidden fields which we need to send with our login, this includes security tokens
        $count = preg_match_all('/<input type="hidden"\s*name="([^"]*)"\s*value="([^"]*)"/i', $form, $hiddenFields);

        $postFields = array();

        // turn the hidden fields into an array
        for ($i = 0; $i < $count; ++$i) {
            $postFields[$hiddenFields[1][$i]] = $hiddenFields[2][$i];
        }

        // add our login values
        $postFields['username'] = $USERNAME;
        $postFields['password'] = $PASSWORD;   

        $post = '';

        // convert to string, this won't work as an array, form will not accept multipart/form-data, only application/x-www-form-urlencoded
        foreach($postFields as $key => $value) {
            $post .= $key . '=' . urlencode($value) . '&';
        }

        $post = substr($post, 0, -1);   

        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $page, $matches);

        $cookieFileContent = '';

        foreach($matches[1] as $item) 
        {
            $cookieFileContent .= "$item; ";
        }

        $cookieFileContent = rtrim($cookieFileContent, '; ');
        $cookieFileContent = str_replace('sessionid=""; ', '', $cookieFileContent);

        $oldContent = file_get_contents(dirname(__FILE__)."/!instagram/".$COOKIE);
        $oldContArr = explode("\n", $oldContent);

        if(count($oldContArr))
        {
            foreach($oldContArr as $k => $line)
            {
                if(strstr($line, '# '))
                {
                    unset($oldContArr[$k]);
                }
            }

            $newContent = implode("\n", $oldContArr);
            $newContent = trim($newContent, "\n");

            file_put_contents(
                dirname(__FILE__)."/!instagram/".$COOKIE,
                $newContent
            );    
        }

        $arrSetHeaders = array(
            'origin: https://www.instagram.com',
            'authority: www.instagram.com',
            'upgrade-insecure-requests: 1',
            'Host: www.instagram.com',
            "User-Agent: $USERAGENT",
            'content-type: application/x-www-form-urlencoded',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: deflate, br',
            "Referer: $url",
            "Cookie: $cookieFileContent",
            'Connection: keep-alive',
            'cache-control: max-age=0',
        );

        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/!instagram/".$COOKIE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/!instagram/".$COOKIE);
        curl_setopt($ch, CURLOPT_USERAGENT, $USERAGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrSetHeaders);     
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        sleep(5);
        $page = curl_exec($ch);

        /*
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $page, $matches);
        COOKIEs = array();
        foreach($matches[1] as $item) {
            parse_str($item, COOKIE1);
            COOKIEs = array_merge(COOKIEs, COOKIE1);
        }
        */
        //var_dump($page);      
        curl_close($ch);  
    }

    private function convResponseCode($code)
    {
        switch ($code) {
            case '200':
                $status = 'Ditemukan.';
                break;
            case '404':
                $status = 'Tidak Ditemukan.';
                break;
            case '500':
                $status = 'Terjadi kesalahan.';
                break;
            case false:
                $status = 'Tidak ditemukan.';
                break;
            case true:
                $status = 'Ditemukan.';
                break;
            
            default:
                $status = '-';
                break;
        }

        return $status;
    }
}