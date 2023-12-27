<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\OsintModel;

use AuthHelper, FormHelper;

class OsintTiktokController extends Controller
{   
    public function __construct()
    {
      $this->middleware('is_login_isec');
    }
    
    public function reqUrl($url)
    {
      $curl = curl_init();

      curl_setopt_array($curl, [
          // CURLOPT_URL => "https://tiktok82.p.rapidapi.com/getProfile?username=$keyword",
          // CURLOPT_URL => "https://tiktok-scraper7.p.rapidapi.com/user/info?unique_id=$keyword",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: tiktok-scraper7.p.rapidapi.com",
            "X-RapidAPI-Key: f1b580a982mshdda8208830c1a51p10d042jsn33152d557a3d"
          ],
      ]);

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
          // echo "cURL Error #:" . $err;
          $res = [
            'status' => false,
          ];
      } else {
          // echo $response;die();
          $res = [
            'status' => true,
            'content' => json_decode($response)
          ];
      }
      
      $res = (object) $res;
      
      return $res;
    }

    public function userInfo($keyword) 
    {
      $reqUser = self::reqUrl("https://tiktok-scraper7.p.rapidapi.com/user/info?unique_id=$keyword");
      // $reqUser = self::jsonRes();

      // dd($reqUser);
      $data = [];
      $content = [];
      if($reqUser->status && (isset($reqUser->content->code) && $reqUser->content->code == '0'))
      {
        $data['tkStatusUser'] = $reqUser->content->code == '0' ? true : false;
        $data['tkUserName'] = $reqUser->content->data->user->uniqueId;
        $data['tkName'] = $reqUser->content->data->user->nickname;

        // $content['1'] = $req->content->data->user->nickname;
        // $content['2'] = $req->content->data->user->nickname;
        // $data['content'] = (object) $content;
      }

      $res = (object) $data;

      return $res;
    }

    public function userPost($keyword) 
    {
      $reqPost = self::reqUrl("https://tiktok-scraper7.p.rapidapi.com/user/posts?unique_id=$keyword&count=10&cursor=0");
      // $reqUser = self::jsonResVideo();

      $data = [];
      $content = [];
      if($reqPost->status && (isset($reqPost->content->code) && $reqPost->content->code == '0'))
      {
        // dd($reqPost->content);
        $data['tkStatusVideo'] = $reqPost->content->code == '0' ? true : false;
        $data['videos'] = $reqPost->content->data->videos;

        // $content['1'] = $req->content->data->user->nickname;
        // $content['2'] = $req->content->data->user->nickname;
        // $data['content'] = (object) $content;
      }

      $res = (object) $data;

      // dd($res);
      return $res;
    }

    public function jsonRes() 
    {
      $res = '{
        "code": 0,
        "msg": "success",
        "processed_time": 0.4207,
        "data": {
          "user": {
            "id": "7142755407307785217",
            "uniqueId": "kliniksecurity",
            "nickname": "Klinik Security",
            "avatarThumb": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_100x100.jpeg?x-expires=1701932400&x-signature=6i2nePSWXxgxxanOza1VI7CyJiI%3D",
            "avatarMedium": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_720x720.jpeg?x-expires=1701932400&x-signature=Rt81VPermWIv1vzwME%2BzMr82Ek4%3D",
            "avatarLarger": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701932400&x-signature=Zs8R6wcB47iyv%2FFBPLjKVxDpISQ%3D",
            "signature": "Update Informasi dan Peristiwa Terkini Lingkungan PT Astra Daihatsu Motor",
            "verified": false,
            "secUid": "MS4wLjABAAAA1Wq7L1sB233Hp_EQZiyTHlm5e7yVHl5JwdClwQwQSuNSA17zN4X8rEfGhl6IIbOK",
            "secret": false,
            "ftc": false,
            "relation": 0,
            "openFavorite": false,
            "commentSetting": null,
            "duetSetting": null,
            "stitchSetting": null,
            "privateAccount": false,
            "isADVirtual": false,
            "isUnderAge18": false,
            "ins_id": "",
            "twitter_id": "",
            "youtube_channel_title": "",
            "youtube_channel_id": ""
          },
          "stats": {
            "followingCount": 7,
            "followerCount": 17,
            "heartCount": 54,
            "videoCount": 8,
            "diggCount": 0,
            "heart": 54
          }
        }
      }';

      $res = [
        'status' => '000',
        'content' => json_decode($res)
      ];
      
      $res = (object) $res;
      
      return $res;
    }

    public function jsonResVideo() 
    {
        $res = '{
          "code": 0,
          "msg": "success",
          "processed_time": 0.5826,
          "data": {
            "videos": [
              {
                "aweme_id": "v09044g40000ckmvisbc77u4cenipmog",
                "video_id": "7290758703177846022",
                "region": "ID",
                "title": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟 Rangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara periode 08 - 13 Oktober 2023.  #KilasKriminal #Kriminalitas #BeritaTerkini #BeritaTikTok #FYP #SeputarSunter #InfoJakut #SeputarJakut #InfoKarawang #KlinikSecurity #DaihatsuSahabatku #satuindonesia ",
                "cover": "https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/e3cc30c919c5440d929efbf63d5c9433_1697512075?x-expires=1701846000&x-signature=8LGQQPhwvZWLb7bnI56wdNM4%2FIU%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/94a7974ec5e64bcb93f6c1d5fc189af8_1697512352~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=MIB48cF5Yp7LwCmPRgw6ifF3LHk%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 104,
                "play": "https://v19-us.tiktokcdn.com/475371720072f14530be40cda06cf19b/656f2754/video/tos/useast2a/tos-useast2a-ve-0068c002/oIelqNjKWA2ZCtxgDI1fpjeCSGbbI656IxigQn/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1088&bt=544&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=Ojc6aTg7Mzk4Zzc6ZGhoO0BpanBsaDc6ZnZ5bjMzNzczM0BiNDNjYmM1XjMxMC8tNF4uYSNsbWtgcjRfZmpgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/500efcaabf03b48ad15e769be8fa7115/656f2754/video/tos/useast2a/tos-useast2a-ve-0068c004/oAInKWgIh5xfICixXQlCDZGADRSqbtTQ1gbeje/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1492&bt=746&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=ZTZnaDRnaTk7ZGU4Omc3ZkBpanBsaDc6ZnZ5bjMzNzczM0AuNi8wLzZiXjYxYjQ2Xy4zYSNsbWtgcjRfZmpgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "size": 7296747,
                "wm_size": 10012715,
                "music": "https://sf16-ies-music-va.tiktokcdn.com/obj/musically-maliva-obj/7290758861492570886.mp3",
                "music_info": {
                  "id": "7290758859169467142",
                  "title": "original sound - kliniksecurity",
                  "play": "https://sf16-ies-music-va.tiktokcdn.com/obj/musically-maliva-obj/7290758861492570886.mp3",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 104,
                  "album": ""
                },
                "play_count": 114,
                "digg_count": 0,
                "comment_count": 0,
                "share_count": 0,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1697512045,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v09044g40000cjf01ajc77u032tlnoj0",
                "video_id": "7268248163583069445",
                "region": "ID",
                "title": "Hi Sahabat Daihatsu..  Masih semangat kemerdekaan nih yaaa... Yuks kita tengok keseruan kegiatan upacara bendera 17 Agustus 2023 di PT Astra Daihatsu Motor. Dirgahayu ke-78 Republik Indonesia, semoga Indonesia menjadi negara yang makin maju, kuat, dan sejahtera rakyatnya!  #HUTRI78 #17Agustus #DirgahayuIndonesia #KemerdekaanIndonesia #IndonesiaMerdeka #Informasi #BeritaTerkini #SeputarSunter #InfoJakut #SeputarJakut #InfoKarawang #JakartaUtara #Karawang #KlinikSecurity #DaihatsuSahabatku #SatuIndonesia",
                "cover": "https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/fdff5668f5a948029903e0b4145a4da4_1692270923?x-expires=1701846000&x-signature=SazknyPe4IRIq24AlLaZkNFjAoY%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/a898aca64d67402d9acd58c8d076121a_1692270924~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=Rpqn%2B8hMOnf7Ol3dS%2BDP1Vt7T9Q%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 89,
                "play": "https://v19-us.tiktokcdn.com/d7dce1d47f0a837abd3fe074c0a15685/656f2745/video/tos/useast2a/tos-useast2a-ve-0068c004/okieRgYSkgJHEUBAAB38oeCDR1nBYEAvqQbDXu/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=3272&bt=1636&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=OztnODk4ZjVoZWVoaWU8aEBpM3JvNTM6ZmQzbTMzNzczM0A0MDY1MWBfXjExMGJhXzYxYSNna3EwcjRnLmNgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/8c5cbac8b5b47b0bf4ba1012245c2842/656f2745/video/tos/useast2a/tos-useast2a-ve-0068c003/owQo3DgakBC5yxqAAnBBm8o3egCQJIbRrEXMfM/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=3674&bt=1837&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=Njo0aDo2ZTZkNmY5ZTw8NEBpM3JvNTM6ZmQzbTMzNzczM0A1LS1iM2MzX18xLi40YDY1YSNna3EwcjRnLmNgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "size": 18697431,
                "wm_size": 20992578,
                "music": "",
                "music_info": {
                  "id": "7268248188106607365",
                  "title": "original sound - kliniksecurity",
                  "play": "",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 89,
                  "album": ""
                },
                "play_count": 58,
                "digg_count": 1,
                "comment_count": 0,
                "share_count": 0,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1692270900,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v09044g40000chmnpkjc77u29kuifssg",
                "video_id": "7236578190771113221",
                "region": "ID",
                "title": "𝗦𝗘𝗖𝗨𝗥𝗜𝗧𝗬 𝗧𝗜𝗣𝗦  Sahabat, agar tidak menduga-duga atau terpancing emosi dengan beredarnya berita hoax yang belum jelas kebenarannya, @kliniksecurity akan berbagi tips untuk menangkalnya.  #SecurityTips #Hoax #Berita #Informasi #BeritaTerkini #Tips #BeritaTikTok #FYP #SeputarSunter #InfoJakut #SeputarJakut #InfoKarawang #KlinikSecurity #DaihatsuSahabatku #SatuIndonesia",
                "cover": "https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/5cc1dc3a11484e5ba7cd58fc262628fe_1684897199?x-expires=1701846000&x-signature=z8xAmnrwdzUdHdCNyxZGcq2A1GM%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/f921ad45b9df41d99903b4bec396876a_1684897201~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=QbnBdTuAEufc%2FcVlXip2G2lgozk%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 78,
                "play": "https://v19-us.tiktokcdn.com/8888f30e19639979fd7c192b82f90d93/656f273a/video/tos/useast2a/tos-useast2a-ve-0068c004/oAJnyJNwDTEgIceQkX5ApfXbmzERBSEbaQBbnP/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1016&bt=508&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=aTM6O2ZlZmlmNDVlOzdlNEBpanZsbjU6Zm5xazMzNzczM0AxYC4wX2AvXjQxXzMzMDFjYSNwY3I2cjRnbWpgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/cab6528475396f49fb896ef9519bac52/656f273a/video/tos/maliva/tos-maliva-ve-0068c801-us/oQyzhgJnkBfE5wPeDMoXWAQmEBpabb5QnRobrS/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1316&bt=658&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=OWhkZDw6NzgzOGk2NWhmNEBpanZsbjU6Zm5xazMzNzczM0BeYzYtYi00XzYxLjUzYF8zYSNwY3I2cjRnbWpgLS1kMTZzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "size": 5114215,
                "wm_size": 6625148,
                "music": "https://sf16-ies-music-va.tiktokcdn.com/obj/musically-maliva-obj/7236578358675049222.mp3",
                "music_info": {
                  "id": "7236578342328519430",
                  "title": "original sound - kliniksecurity",
                  "play": "https://sf16-ies-music-va.tiktokcdn.com/obj/musically-maliva-obj/7236578358675049222.mp3",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 78,
                  "album": ""
                },
                "play_count": 383,
                "digg_count": 6,
                "comment_count": 0,
                "share_count": 0,
                "download_count": 2,
                "collect_count": 2,
                "create_time": 1684897163,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v0f025gc0000cga1akjc77ucusmb08ug",
                "video_id": "7211412577618857242",
                "region": "ID",
                "title": "𝗦𝗘𝗖𝗨𝗥𝗜𝗧𝗬 𝗧𝗜𝗣𝗦 Sahabat, pencurian spion mobil masih marak terjadi. Kali ini @kliniksecurity akan berbagi tips untuk menghindarinya.  #SecurityTips #PencurianSpion #Pencurian #Spion #Tips #BeritaTerkini #BeritaTikTok #FYP #SeputarSunter #InfoJakut #SeputarJakut #InfoKarawang #KlinikSecurity #DaihatsuSahabatku #SatuIndonesia",
                "cover": "https://p16-sign-useast2a.tiktokcdn.com/obj/tos-useast2a-p-0037-aiso/3d278897cc6b4ae0a31f03b6a6cad10f_1679037867?x-expires=1701846000&x-signature=uaJGjSfKZI7x6AglRE7IhzIa%2BsM%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-p-0037-aiso/4672fdbd4f3f4061b3c8b92498da5779_1679037867~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=eP59uZ6PyhBUnmTGsyE0TwRReUw%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 79,
                "play": "https://v19-us.tiktokcdn.com/5098f417d0a5a305bb1e3127f1502d67/656f273b/video/tos/useast2a/tos-useast2a-pve-0037c001-aiso/ooIpqMQ9IhIyo0FhgFyBUzbACU3ynwONoA9fcK/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1072&bt=536&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=Zmg5M2QzNjk6PDtoaDNlPEBpajtldmY6Zm40ajMzZjgzM0AwL2AyYF8yNl4xYy8xX2E2YSNyLWpycjRnXl5gLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/f3ad4226cfeb200c81179a44f16bf6c2/656f273b/video/tos/useast2a/tos-useast2a-pve-0037c001-aiso/ocxhPRDIQAV5D3zjV8bLBknBeZFf0DCAa7LSAR/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=1330&bt=665&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=M2ZlM2ZmZTRpZTY8PDdoaUBpajtldmY6Zm40ajMzZjgzM0A2NV80NWEvXjUxLS8tNjYyYSNyLWpycjRnXl5gLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "size": 5480437,
                "wm_size": 6798813,
                "music": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7211412712080526107.mp3",
                "music_info": {
                  "id": "7211412700147026715",
                  "title": "original sound - kliniksecurity",
                  "play": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7211412712080526107.mp3",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 79,
                  "album": ""
                },
                "play_count": 2072,
                "digg_count": 21,
                "comment_count": 0,
                "share_count": 2,
                "download_count": 2,
                "collect_count": 6,
                "create_time": 1679037839,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v0f025gc0000cg1hpmbc77u3t58n2is0",
                "video_id": "7206635703294332186",
                "region": "ID",
                "title": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟 Rangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara (27 Februari - 03 Maret 2023) #KilasKriminal #Kriminalitas #BeritaTerkini #TikTokBerita #FYP #SeputarSunter #InfoJakut #SeputarJakut #InfoKarawang #KlinikSecurity #DaihatsuSahabatku #SatuIndonesia",
                "cover": "https://p16-sign-useast2a.tiktokcdn.com/obj/tos-useast2a-p-0037-aiso/8ca9c97371034436bbdd612e08b012f2_1677925638?x-expires=1701846000&x-signature=dzZglJ%2FDznDfSDLUSOQGAdxpBYg%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-p-0037-aiso/86ab1763aa7a465cad56993a41b099ed_1677925637~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=BbaA8UBlU%2B8Cdm36uRpV3dMcEFU%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 67,
                "play": "https://v19-us.tiktokcdn.com/2c04ac0d36789409441865c5e032ab1f/656f272f/video/tos/useast2a/tos-useast2a-pve-0037-aiso/os56DAtVnAUQ4HKMBsoFIxfhTFCSKyDRzQhYAA/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=528&bt=264&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=OmU3ZGhoNGRkOWQ6NjM4Z0BpM2xxODY6ZnBrajMzZjgzM0AxMDNfNGNjXjUxYl5iNi1jYSNwLzVxcjRfbS5gLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/cf4faa13b3e03738486cf23adc5163ca/656f272f/video/tos/useast2a/tos-useast2a-pve-0037c001-aiso/oIlHVxw7kQPGCUDHTBAeeYzDoLng0RAiZQbD7q/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&cv=1&br=772&bt=386&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=M2c6NWRmZDo6ZjZnZTY8N0BpM2xxODY6ZnBrajMzZjgzM0AyXzAtMGNiNTQxYTY1MjNiYSNwLzVxcjRfbS5gLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00090000&cc=25",
                "size": 2264412,
                "wm_size": 3312674,
                "music": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7206635729976298266.mp3",
                "music_info": {
                  "id": "7206635712710478618",
                  "title": "original sound - kliniksecurity",
                  "play": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7206635729976298266.mp3",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 67,
                  "album": ""
                },
                "play_count": 856,
                "digg_count": 15,
                "comment_count": 0,
                "share_count": 3,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1677925635,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v0f025gc0000cd4ckejc77u5mjcohg40",
                "video_id": "7154191170510359835",
                "region": "ID",
                "title": "Siapa nih yang masih sering buru-buru share informasi? Yuk lebih bijak🙅‍♀️ #fyp #Viral #hoaks #information  (ib: @kemkominfo )",
                "cover": "https://p16-sign-useast2a.tiktokcdn.com/obj/tos-useast2a-p-0037-aiso/9ab74bb7b1d14728918171c876742531_1665715037?x-expires=1701846000&x-signature=NC9yXrBRbsujZBVZnder%2BqaDS8o%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-p-0037-aiso/f907ccec9e2a4438b39a08aa114ee6bb_1665715037~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=62oZ85ZKZ8YIQtSJaRF8rW6imj0%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 15,
                "play": "https://v19-us.tiktokcdn.com/6b9fd533d052e588f59ea32b42334faf/656f26fb/video/tos/maliva/tos-maliva-ve-0068c801-us/a977a8c3fece4dec8246a5d92d8442a1/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=2832&bt=1416&bti=M0BzMzU8OGYpNzo5Zi5wIzEuLjpkNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=ZDM2ZmY4MzRoNDs0ZmRpO0BpM2pybTg6ZmhmZzMzZjgzM0AxMzAuLzMzXjQxLS9hYjBiYSMxZWBqcjRnaDFgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/4fb78de02c0b1c8bd9d061640c43b787/656f26fb/video/tos/useast2a/tos-useast2a-pve-0037-aiso/485909d54d214306bda63633fea549dd/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=3046&bt=1523&bti=M0BzMzU8OGYpNzo5Zi5wIzEuLjpkNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=NmY5PGU3ZzU3ZmVkZDM4O0BpM2pybTg6ZmhmZzMzZjgzM0BiYzAxNDZiXi4xLzQvXy1gYSMxZWBqcjRnaDFgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "size": 2757480,
                "wm_size": 2943081,
                "music": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/6991835129287412506.mp3",
                "music_info": {
                  "id": "6991835150325779227",
                  "title": "Clap Snap",
                  "play": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/6991835129287412506.mp3",
                  "cover": "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/ab3f3dc4b5d83d1c38b4df53c3ace54d~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=1N6pdBqvM2oMqJP%2BNuD83addlH4%3D",
                  "author": "Nanay Mitchay ❤️",
                  "original": true,
                  "duration": 26,
                  "album": ""
                },
                "play_count": 100,
                "digg_count": 5,
                "comment_count": 1,
                "share_count": 0,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1665714941,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v0f025gc0000ccn8ddjc77u4ddlnkd10",
                "video_id": "7146798414003571995",
                "region": "ID",
                "title": "Pada event \"Astra Security Competition 2022\" yang diselenggarakan dari 23 Agustus - 15 September 2022 diikuti 33 perusahaan Astra Group, PT Astra Daihatsu Motor (ADM) meraih JUARA UMUM dengan perolehan 2 emas (Lomba Investigasi & Cerdas Cermat) dan 1 perak (Lomba Security Risk Assesment). Hadiah diterima oleh perwakilan Management PT Astra Daihatsu Motor yaitu Bapak Yoga D. Suryawan (Head, General Affairs Division) dan Bapak Rony Hapsoro (Head, External Affairs Department). Sumber : EA Department Security Information EA Dept. - GA Div. PT Astra Daihatsu Motor Instagram : http://bit.ly/Instagram-KlinikSecurity Email : security.hotline@daihatsu.astra.co.id #fyp ",
                "cover": "https://p16-sign-useast2a.tiktokcdn.com/obj/tos-useast2a-p-0037-aiso/2d14f11db8ad48bda9547578d26974d7_1663993683?x-expires=1701846000&x-signature=LLRX%2BuuhhfTMe%2BbWUeRtDuSlS10%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-p-0037-aiso/df8fb369619d4016b248f02d3a7a04ea_1663993683~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=XgZWzQmGJYh9HtaI1MyeBFRcQIM%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 15,
                "play": "https://v19-us.tiktokcdn.com/0bb59b532c2863f827b7d446171e8b35/656f26fb/video/tos/maliva/tos-maliva-ve-0068c801-us/29f97a72269146809bb907721b648622/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=198&bt=99&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=NWc8MzdpOTpkNjg3Z2k5aEBpM2dxZzc6Zmc7ZjMzZjgzM0BjLzQ0Xi42XzQxM2MvMmFjYSMuaGlhcjRnYWtgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/89a7ef83c92727589415904b3241decd/656f26fb/video/tos/useast2a/tos-useast2a-pve-0037-aiso/ebc46d12fa2c483085b95dfca522c50c/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=406&bt=203&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=Zzc6aDk0Nmg0Njk1OTloZUBpM2dxZzc6Zmc7ZjMzZjgzM0A0YzNfMzUxNWIxNDUvM15fYSMuaGlhcjRnYWtgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "size": 192355,
                "wm_size": 391122,
                "music": "https://sf16-ies-music-va.tiktokcdn.com/obj/tos-useast2a-ve-2774/oQnS9QHDYBJ66QDBwbZutyaBO2f4VgX2drCqek",
                "music_info": {
                  "id": "6717100931294431234",
                  "title": "Breaking News",
                  "play": "https://sf16-ies-music-va.tiktokcdn.com/obj/tos-useast2a-ve-2774/oQnS9QHDYBJ66QDBwbZutyaBO2f4VgX2drCqek",
                  "cover": "https://p16-amd-va.tiktokcdn.com/img/tos-useast2a-v-2774/f4e99e0f7e674ffbad05ff7b01b93940~c5_720x720.jpeg",
                  "author": "",
                  "original": false,
                  "duration": 60,
                  "album": "News Music"
                },
                "play_count": 177,
                "digg_count": 3,
                "comment_count": 0,
                "share_count": 0,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1663993681,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              },
              {
                "aweme_id": "v0f025gc0000ccmio2jc77u4ddla9c1g",
                "video_id": "7146416650370174234",
                "region": "ID",
                "title": "NEWSPAPERExecutive NewsSemangat Pagi Sahabat DaihatsuCEGAH PENCURIAN DATA PRIBADISahabat, tingginya penggunaan teknologi berbasis internet telah memicu tindak kejahatan. Salah satu diantaranya adalah pencurian data pribadi. Kali ini @kliniksecurity mau kasih tips cara melindungi data pribadi sebagai upaya antisipatif dampak negatif melakukan aktivitas cyber. Yuk cek detailnya di atas :)Sumber : EA DepartementSecurity InformationEA Dept. - GA Div.PT Astra Daihatsu MotorInstagram : http://bit.ly/Instagram-KlinikSecurityEmail : security.hotline@daihatsu.astra.co.id #fyp",
                "cover": "https://p16-sign-useast2a.tiktokcdn.com/obj/tos-useast2a-p-0037-aiso/ec7ae9c40f9d428398e0c02246dcbd31_1663904795?x-expires=1701846000&x-signature=p9HHT8tC9SDPZMC2uGp8fnnrtRg%3D&s=PUBLISH&se=false&sh=&sc=dynamic_cover&l=2023120507343535FF49A631866200243B",
                "origin_cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-p-0037-aiso/7e8c8ff63f3c411fbcba56b8015bbfce_1663904795~tplv-tiktokx-360p.webp?x-expires=1701846000&x-signature=vYty0H%2BWKelMb8LPUksYmN9qeGY%3D&s=PUBLISH&se=false&sh=&sc=feed_cover&l=2023120507343535FF49A631866200243B",
                "duration": 29,
                "play": "https://v19-us.tiktokcdn.com/ec7f153afecdee4f906ccf3b12f21a8a/656f2709/video/tos/useast2a/tos-useast2a-pve-0037-aiso/9b4c51dd4b7049e4a7ca033d2b90b840/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=252&bt=126&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=6&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=NGc3ODM2Nzo1PDQ7NTZnOEBpamZkZzc6ZjVsZjMzZjgzM0AtMl4xNl9iXzAxYjAwNDYxYSMuNmlhcjRnbGpgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "wmplay": "https://v19-us.tiktokcdn.com/3a29e239eb2d6673bbd0e6842e43b733/656f2709/video/tos/useast2a/tos-useast2a-pve-0037-aiso/f1c49d027995496cb4f4e0972efb4083/?a=1340&ch=0&cr=13&dr=0&lr=all&cd=0%7C0%7C0%7C&br=486&bt=243&bti=MzU8OGYpNHYpNzo5ZjEuLjpkLTptNDQwOg%3D%3D&cs=0&ds=3&ft=kLeRJy7oZ-m0PD1_~sCxg9whq.hJBEeC~&mime_type=video_mp4&qs=0&rc=OTs4M2c8O2VpNGZlZzc1N0BpamZkZzc6ZjVsZjMzZjgzM0A2LmIvLjAzXjUxL18wLS1fYSMuNmlhcjRnbGpgLS1kL2Nzcw%3D%3D&l=2023120507343535FF49A631866200243B&btag=e00088000&cc=25",
                "size": 482105,
                "wm_size": 926359,
                "music": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7146416702828350235.mp3",
                "music_info": {
                  "id": "7146416677549296410",
                  "title": "original sound - kliniksecurity",
                  "play": "https://sf16-ies-music.tiktokcdn.com/obj/ies-music-aiso/7146416702828350235.mp3",
                  "cover": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_1080x1080.jpeg?x-expires=1701846000&x-signature=gGrkDTuhAX%2BF6oOHGmg8d1Ft6UY%3D",
                  "author": "Klinik Security",
                  "original": true,
                  "duration": 29,
                  "album": ""
                },
                "play_count": 72,
                "digg_count": 3,
                "comment_count": 0,
                "share_count": 0,
                "download_count": 0,
                "collect_count": 0,
                "create_time": 1663904793,
                "anchors": null,
                "anchors_extras": "",
                "is_ad": false,
                "commerce_info": {
                  "adv_promotable": false,
                  "auction_ad_invited": false,
                  "branded_content_type": 0,
                  "with_comment_filter_words": false
                },
                "commercial_video_info": "",
                "author": {
                  "id": "7142755407307785217",
                  "unique_id": "kliniksecurity",
                  "nickname": "Klinik Security",
                  "avatar": "https://p16-sign-useast2a.tiktokcdn.com/tos-useast2a-avt-0068-giso/db1e6022b450e7ceeec7d404c60a937e~c5_300x300.jpeg?x-expires=1701846000&x-signature=fXhPl%2BKj3cXWEGmTFYBeaxEa%2FYk%3D"
                },
                "is_top": 0
              }
            ],
            "cursor": "1663904793000",
            "hasMore": false
          }
        }';

        $res = [
          'status' => '000',
          'content' => json_decode($res)
        ];
        
        $res = (object) $res;
        
        return $res;
    }
}