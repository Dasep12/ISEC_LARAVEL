<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\OsintModel;

use AuthHelper;
use FormHelper;

class OsintProfileController extends Controller
{
    private static $moduleCode = 'SRSOSI';
    
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function search(Request $req) {
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

            $html = '<div id="searchResultProfile" class="row px-2 mt-4 mb-1">';

            try {
                $html .= self::getInstagram($keyword);
                $html .= self::getTiktok($keyword);
                $html .= self::getEmail($keyword);
            } catch (Exception $e) {
                $html .= 'Caught exception: ,'.  $e->getMessage(). "\n";
            }
            
            $html .= '</div>';
    
            echo $html;
        }
    }

    public function searchTest() {
        $urlSosmed = array(
            'https://www.tiktok.com/@',
            'https://www.instagram.com/', 
            'https://www.facebook.com/',
        );

        $keyword = 'kliniksecurity';
        // $url = 'https://bibliogram.art/u/';
        $url = "https://www.instagram.com/";
        // $url = "https://www.tiktok.com/@{$keyword}";

        // $reqRapid = self::reqRapidUsername('instagram',$keyword);
        
        $req = self::getInstagram($keyword);
        var_dump($req);
        die();

        $html = '<div id="searchResultProfile" class="row px-2 mt-4 mb-1">';
            // echo self::getInstagram($keyword);
            echo self::getTiktok($keyword);
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

        // $dataJson = json_decode('{"seo_category_infos":[["Beauty","beauty"],["Dance & Performance","dance_and_performance"],["Fitness","fitness"],["Food & Drink","food_and_drink"],["Home & Garden","home_and_garden"],["Music","music"],["Visual Arts","visual_arts"]],"logging_page_id":"profilePage_1315590476","show_suggested_profiles":false,"graphql":{"user":{"ai_agent_type":null,"biography":"\ud83d\udcbb Programmer\nFounder of inkeki.com @inkeki , digitalm2.com @digital.m2\n \n\ud83d\udc8d @ennoviana07","bio_links":[{"title":"","lynx_url":"https://l.instagram.com/?u=https%3A%2F%2Fdigitalm2.com%2F&e=AT2KSAqpmDtt5wqtFM00rFwMu07aLeunn-B3zx_XCSHkbSjt0E6lJunjRmNeKN1GSC9c4K9mIUDnyLGgi0J0RuUVbh0WwczB9KxATvU","url":"https://digitalm2.com/","link_type":"external"}],"fb_profile_biolink":null,"biography_with_entities":{"raw_text":"\ud83d\udcbb Programmer\nFounder of inkeki.com @inkeki , digitalm2.com @digital.m2\n \n\ud83d\udc8d @ennoviana07","entities":[{"user":{"username":"digital.m2"},"hashtag":null},{"user":{"username":"inkeki"},"hashtag":null},{"user":{"username":"ennoviana07"},"hashtag":null}]},"blocked_by_viewer":false,"restricted_by_viewer":false,"country_block":false,"eimu_id":"124268918965245","external_url":"https://digitalm2.com/","external_url_linkshimmed":"https://l.instagram.com/?u=https%3A%2F%2Fdigitalm2.com%2F&e=AT2Jn8SbMGbXZ46n_2UNZRhZfj5Bz73EafpfSWFeb5GNQSN5kFYsKAPSFEOQG0l31GlTa-sXeLSJQRdn4_Mf9gacIE-sV0S5llEf_hQ","edge_followed_by":{"count":207},"fbid":"17841400194300556","followed_by_viewer":false,"edge_follow":{"count":239},"follows_viewer":false,"full_name":"Ri Fe","group_metadata":null,"has_ar_effects":false,"has_clips":true,"has_guides":false,"has_channel":false,"has_blocked_viewer":false,"highlight_reel_count":0,"has_requested_viewer":false,"hide_like_and_view_counts":false,"id":"1315590476","is_business_account":false,"is_professional_account":false,"is_supervision_enabled":false,"is_guardian_of_viewer":false,"is_supervised_by_viewer":false,"is_supervised_user":false,"is_embeds_disabled":false,"is_joined_recently":false,"guardian_id":null,"business_address_json":null,"business_contact_method":"UNKNOWN","business_email":null,"business_phone_number":null,"business_category_name":null,"overall_category_name":null,"category_enum":null,"category_name":null,"is_private":true,"is_verified":false,"is_verified_by_mv4b":false,"is_regulated_c18":false,"edge_mutual_followed_by":{"count":0,"edges":[]},"pinned_channels_list_count":0,"profile_pic_url":"https://instagram.fbom68-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?stp=dst-jpg_e0&_nc_ht=instagram.fbom68-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=Pp5hp7kbPTMAX_ZZ351&edm=AL4D0a4BAAAA&ccb=7-5&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2-ccb7-5&oh=00_AfAQkuP0tae2Ww0elpNws_yRyIgEc1HsP5maF54Eb3eNhw&oe=652BF3CF&_nc_sid=9e8221","profile_pic_url_hd":"https://instagram.fbom68-1.fna.fbcdn.net/v/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?stp=dst-jpg_e0&_nc_ht=instagram.fbom68-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=Pp5hp7kbPTMAX_ZZ351&edm=AL4D0a4BAAAA&ccb=7-5&ig_cache_key=YW5vbnltb3VzX3Byb2ZpbGVfcGlj.2-ccb7-5&oh=00_AfAQkuP0tae2Ww0elpNws_yRyIgEc1HsP5maF54Eb3eNhw&oe=652BF3CF&_nc_sid=9e8221","requested_by_viewer":false,"should_show_category":false,"should_show_public_contacts":false,"show_account_transparency_details":true,"transparency_label":null,"transparency_product":"STATE_CONTROLLED_MEDIA","username":"rife.rf","connected_fb_page":null,"pronouns":[],"edge_felix_video_timeline":{"count":12,"page_info":{"has_next_page":false,"end_cursor":""},"edges":[]},"edge_owner_to_timeline_media":{"count":246,"page_info":{"has_next_page":true,"end_cursor":"QVFCS2JBZThFWGtmanlDb3JEZkkyRnNLV3BMMzRCWWl6SWZxU2UwMnhJRGpUeTEzZ0h0QkNJd096Vld5VTNpMDZhOEd3Ymp1RkxkUzA0ZDV4S0lFcFgzUw=="},"edges":[]},"edge_saved_media":{"count":0,"page_info":{"has_next_page":false,"end_cursor":null},"edges":[]},"edge_media_collections":{"count":0,"page_info":{"has_next_page":false,"end_cursor":null},"edges":[]}}},"toast_content_on_load":null,"show_qr_modal":false,"show_view_shop":false}');
        
        $res = self::reqUrl($urlReq);
        $dataJson = json_decode($res['content']);

        // dd($dataJson);

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
        
        $html = '<div class="col-12 p-2">';
        $html .= $data->http_code == 200 ? '<a href="'.$urlEnd.$keyword.'" target="_blank">' : '';
        $html .= '<h5>Instagram: '.$urlEnd.$keyword.'</h5>';
        $html .= $data->http_code == 200 ? '</a>' : '';
        $html .= '<p class="text-white">'.self::ConvResponseCode($data->http_code).'</p>';
        $html .= '</div>';
        
        return $html;
    }

    private function getTiktok($keyword)
    {
        $urlReq = "https://www.tiktok.com/@{$keyword}";
        $urlEnd = "https://www.tiktok.com/@{$keyword}";
        
        $res = self::reqUrl($urlReq);
        $res = json_decode (json_encode ($res), FALSE);

        $html = '<div class="col-12 p-2">';

            $res->header->http_code == '200' ? $html .= '<a href="'.$urlEnd.'" target="_blank">' : '';
            $html .= '<h5>Tiktok: '.$urlEnd.'</h5>';
            $res->header->http_code == '200' ? $html .= '</a>' : '';
            $html .= '<p class="text-white">'.self::ConvResponseCode($res->header->http_code).'</p>';
        $html .= '</div>';
        
        return $html;
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

        $html = '<div class="col-12 p-2">';
            $html .= '<h5>Email: '.$keyword.'</h5>';
            $html .= '<p class="text-white">'.$status.'</p>';
        $html .= '</div>';
        
        return $html;
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
        );
        
        $ch = curl_init($url);
        curl_setopt_array( $ch, $options );

        // Use the visitor's IP address as the proxy address
        // $proxy_address = "103.165.141.217";
        // curl_setopt($ch, CURLOPT_PROXY, $proxy_address);
        // curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        // curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
        // curl_setopt($ch, CURLOPT_PROXY, '128.0.0.3');
        // optional
        // curl_setopt($curlHandle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        // curl_setopt($curlHandle, CURLOPT_PROXYUSERPWD, 'user:s3cr3t'); 
        // curl_setopt($curlHandle, CURLOPT_PROXYAUTH, CURLAUTH_NTLM);
        
        $ips = array(
            '85.10.230.132' => '80',
            '88.198.242.9' => '8080',
            '88.198.242.10' => '5754',
            '88.198.242.11' => '80',
            '88.198.242.12' => '8888',
            '88.198.242.13' => '8989',
            '88.198.242.14' => '8080',
         );
   
        // We get a random key (IP)
        $randomIP = array_rand($ips);
        // curl_setopt($ch, CURLOPT_INTERFACE, $randomIP);
        // curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        
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

    public function reqRapidUsername($platform,$username) 
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://check-username.p.rapidapi.com/check/$platform/$username",
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

        if ($err) 
        {
            return [
                'content' => "cURL Error #:" . $err
            ];
        }

        return [
            'content' => $response
        ];
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
                    $html .= '<a href="'.$url.$keyword.'" target="_blank">'.$url.$keyword.' - '.self::ConvResponseCode($res['http_code']).'</a>';
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

    private function ConvResponseCode($code)
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
            
            default:
                $status = '-';
                break;
        }

        return $status;
    }
}