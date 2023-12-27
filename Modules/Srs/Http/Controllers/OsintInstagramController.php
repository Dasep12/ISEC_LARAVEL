<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\OsintModel;

use AuthHelper, FormHelper;

class OsintInstagramController extends Controller
{   
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }
    
    public function reqUrl($keyword)
    {
      $api="https://i.instagram.com/api/v1/users/web_profile_info/?username=$keyword";
      $userAgent="User-Agent':'Instagram 76.0.0.15.395 Android (24/7.0; 640dpi; 1440x2560; samsung; SM-G930F; herolte; samsungexynos8890; en_US; 138226743)";
      $ch = curl_init($api);
      curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_REFERER, 'https://www.instagram.com/');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("x-ig-app-id: 567067343352427"));

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

      $PROXY_USER = 'hkmqyimt';
      $PROXY_PASS = '4e99ktkscvnl';
      $PROXY_HOST = '38.154.227.167';
      $PROXY_PORT = '6286';

      // curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYPEER, 0);
      // curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$PROXY_USER:$PROXY_PASS");
      // curl_setopt($ch, CURLOPT_PROXY, "https://$PROXY_HOST:$PROXY_PORT");
      $url = 'http://dynupdate.no-ip.com/ip.php';
      $proxy = $PROXY_HOST.':'.$PROXY_PORT;
      $proxyauth = $PROXY_USER.':'.$PROXY_PASS;
  
      // curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
      // //Set the proxy IP.
      // curl_setopt($ch, CURLOPT_PROXY, $PROXY_HOST);
      // //Set the port.
      // curl_setopt($ch, CURLOPT_PROXYPORT, $PROXY_PORT);
      // //Specify the username and password.
      // curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$PROXY_USER:$PROXY_PASS");

      $result = curl_exec($ch);
      curl_close($ch);
      $result=json_decode($result);

      // dd($result);

      if (isset($result->status) && $result->status=="ok")
      {
        $res = [
          'status' => '000',
          'content' => $result
        ];
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

    public function jsonRes() {
      $res = '{
          "data": {
            "user": {
              "ai_agent_type": null,
              "biography": "PT Astra Daihatsu Motor\nManaged by: External Affairs Dept\nMore Information ⬇️⬇️",
              "bio_links": [
                {
                  "title": "",
                  "lynx_url": "https://l.instagram.com/?u=https%3A%2F%2Flinktr.ee%2FSecurityInformation&e=AT08wfR0p3fM3k2_55vC0gjwqtziuu7FE2AlgUEDejpOlEnUFyrHxvfpCRAyMymMfCEB-oVLBDYaZv3gNqRuokJoDr1SToPw",
                  "url": "https://linktr.ee/SecurityInformation",
                  "link_type": "external"
                }
              ],
              "fb_profile_biolink": null,
              "biography_with_entities": {
                "raw_text": "PT Astra Daihatsu Motor\nManaged by: External Affairs Dept\nMore Information ⬇️⬇️",
                "entities": [
                  
                ]
              },
              "blocked_by_viewer": false,
              "restricted_by_viewer": null,
              "country_block": false,
              "eimu_id": "109458043777037",
              "external_url": "https://linktr.ee/SecurityInformation",
              "external_url_linkshimmed": "https://l.instagram.com/?u=https%3A%2F%2Flinktr.ee%2FSecurityInformation&e=AT3Y-Z0ZOGVutpqlKj-Lrmhi2ER3QxpSt3IQ-BTdxY3YHATHVaKM1iReI1EzoRufMLNH_NCULW-qJ0BhCbcYX-6ICA1hAO8O",
              "edge_followed_by": {
                "count": 3613
              },
              "fbid": "17841405680691321",
              "followed_by_viewer": false,
              "edge_follow": {
                "count": 905
              },
              "follows_viewer": false,
              "full_name": "Klinik Security",
              "group_metadata": null,
              "has_ar_effects": false,
              "has_clips": true,
              "has_guides": false,
              "has_channel": false,
              "has_blocked_viewer": false,
              "highlight_reel_count": 48,
              "has_requested_viewer": false,
              "hide_like_and_view_counts": false,
              "id": "5610573356",
              "is_business_account": true,
              "is_professional_account": true,
              "is_supervision_enabled": false,
              "is_guardian_of_viewer": false,
              "is_supervised_by_viewer": false,
              "is_supervised_user": false,
              "is_embeds_disabled": false,
              "is_joined_recently": false,
              "guardian_id": null,
              "business_address_json": null,
              "business_contact_method": "UNKNOWN",
              "business_email": null,
              "business_phone_number": null,
              "business_category_name": "None",
              "overall_category_name": null,
              "category_enum": null,
              "category_name": "Product/service",
              "is_private": false,
              "is_verified": false,
              "is_verified_by_mv4b": false,
              "is_regulated_c18": false,
              "edge_mutual_followed_by": {
                "count": 0,
                "edges": [
                  
                ]
              },
              "pinned_channels_list_count": 0,
              "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/300257697_802181670779127_5432305745191015965_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=103&_nc_ohc=8VE4bTyVfuUAX_YnGep&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfB1EPT-57Dfj0aRqrKEmwHcTYGW350MwOdvsHyjR1DBag&oe=65740E70&_nc_sid=8b3546",
              "profile_pic_url_hd": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/300257697_802181670779127_5432305745191015965_n.jpg?stp=dst-jpg_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=103&_nc_ohc=8VE4bTyVfuUAX_YnGep&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCe52-Ip_d9gQEN2bphllQK8jDLkFmVjKowO6W7FFCAXw&oe=65740E70&_nc_sid=8b3546",
              "requested_by_viewer": false,
              "should_show_category": false,
              "should_show_public_contacts": false,
              "show_account_transparency_details": true,
              "remove_message_entrypoint": false,
              "transparency_label": null,
              "transparency_product": null,
              "username": "kliniksecurity",
              "connected_fb_page": null,
              "pronouns": [
                
              ],
              "edge_felix_video_timeline": {
                "count": 1,
                "page_info": {
                  "has_next_page": false,
                  "end_cursor": ""
                },
                "edges": [
                  
                ]
              },
              "edge_owner_to_timeline_media": {
                "count": 317,
                "page_info": {
                  "has_next_page": true,
                  "end_cursor": "QVFEMzRwcm5QVDdyTzdid2k5NWFDTVo3WVdjMWUwalRiSWpSVEtSSmF3azlBdkVyS3pfeWJNUEk5TVFDblE5UHNlZWhrSFNLQTdVUXdaMkdMdGZBNktiSA=="
                },
                "edges": [
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3248812589647149967",
                      "shortcode": "C0WGdZbvDuP",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfA2DNhfqlmegNsXAuiKPM6npMCe2eOTSNbUlAhU8mZ6GA&oe=6571DB66&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpHWLnrlf++f/AK9L/bVz6r/3zWVRTA1BrFyDnI5/2f8A69FZdFACirgihx94fTn/AD+NVY3MZ3L15/Xg1N9rk9v++RSZcZKO6T9SuRg0U6RzIdx6+3FFMgbSU6koAKKWigD/2Q==",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjQ4ODEyNTg5NjQ3MTQ5OTY3In0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/406434115_1373799316551070_6534286467349115712_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=RKHr22S90hAAX-K8bxd&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAMgzu-ryatlcYw9bJ-yas225uIZj_WXBMrzeYn6V3new&oe=6571606F&_nc_sid=8b3546",
                      "video_view_count": 203,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟 \n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara Periode 25 - 30 November 2023. \n\nSecurity Information \n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1701508791,
                      "edge_liked_by": {
                        "count": 8
                      },
                      "edge_media_preview_like": {
                        "count": 8
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfABhHhOJKlsEv_YM46VB8SG8sEEo1_76PZ2rXdzT0RmTg&oe=6571DB66&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfATRL277r2qCj7bnmc3UcSlWWFgf6wJZRvC4XV68tTDrg&oe=6571DB66&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDCwwqR33yZRS4BQq5wroFryR7M6vkdLA1o0clnY9mgvw&oe=6571DB66&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCgZdU6ENju511Kfp7OBrP6l4dLovII9fgUQoC0Cr4NIw&oe=6571DB66&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfABhHhOJKlsEv_YM46VB8SG8sEEo1_76PZ2rXdzT0RmTg&oe=6571DB66&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405802445_663172535932413_5631275843442997312_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=HXc6Mh3R51AAX_cRVOL&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfABhHhOJKlsEv_YM46VB8SG8sEEo1_76PZ2rXdzT0RmTg&oe=6571DB66&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphSidecar",
                      "id": "3246480197221831925",
                      "shortcode": "C0N0Intv1T1",
                      "dimensions": {
                        "height": 1080,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfAd7cPlOxW88-Vf2RU4YiQ8RATCiB_Mb0ns6ApTTuq0HA&oe=6574AE02&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.23219241000000002,
                              "y": 0.07395723500000001
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": null,
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗡𝗘𝗪𝗦𝗣𝗔𝗣𝗘𝗥 \n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀\n\nSemangat Siang Sahabat Daihatsu,\n\n𝗕𝗮𝘄𝗮𝘀𝗹𝘂 𝗦𝗲𝗴𝗲𝗿𝗮 𝗟𝘂𝗻𝗰𝘂𝗿𝗸𝗮𝗻 \"𝗦𝗶𝘄𝗮𝘀𝗸𝗮𝗺\", 𝗔𝗽𝗹𝗶𝗸𝗮𝘀𝗶 𝗔𝗱𝘂𝗮𝗻 𝗣𝗲𝗹𝗮𝗻𝗴𝗴𝗮𝗿𝗮𝗻 𝗣𝗲𝗺𝗶𝗹𝘂\n\nBadan Pengawas Pemilu (Bawaslu) akan meluncurkan aplikasi Sistem Informasi Pengawasan Kampanye (Siwaskam). Aplikasi ini bisa digunakan untuk pengaduan pelanggaran Pemilu 2024, lho. Ikuti berita selengkapnya pada gambar di atas ya, Sahabat :)\n\nSumber : EA Department \n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#Newspaper\n#Siwaskam\n#AplikasiOnline\n#PolitikUang\n#Pemilu2024\n#PemiluSerentak2024\n#JakartaUtara\n#Karawang\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1701230619,
                      "edge_liked_by": {
                        "count": 6
                      },
                      "edge_media_preview_like": {
                        "count": 6
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfAjZOD3h5weFay4AYV_FCAXGZ--ORf1veCrjzHTcNb7sA&oe=6574AE02&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfCkzuNPQ-RHIJiuYNJUq6gT5lUk4y_1Nx1U4leeVsPihg&oe=6574AE02&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfCnJpxqZ61BOnCrtFOWt7oeh6ydA5Fkcya5zQ_s58lqKg&oe=6574AE02&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfDGzLrveQNTM937TyAGjnHqfp0JyQZE3SCufknH-poMKQ&oe=6574AE02&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfAsZgNszk1h2_yQoSfAFlSu0HJpQlYnTozPfx5ZDPND8Q&oe=6574AE02&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfAjZOD3h5weFay4AYV_FCAXGZ--ORf1veCrjzHTcNb7sA&oe=6574AE02&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "edge_sidecar_to_children": {
                        "edges": [
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3246480193178335563",
                              "shortcode": "C0N0Ij8vHlL",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405204107_380285154428311_8828046272172187155_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=INO7nnjwuUcAX-QAqRt&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzE3ODMzNTU2Mw%3D%3D.2-ccb7-5&oh=00_AfAd7cPlOxW88-Vf2RU4YiQ8RATCiB_Mb0ns6ApTTuq0HA&oe=6574AE02&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  {
                                    "node": {
                                      "user": {
                                        "full_name": "PT Astra Daihatsu Motor",
                                        "followed_by_viewer": false,
                                        "id": "5785282780",
                                        "is_verified": false,
                                        "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                        "username": "sahabatadm"
                                      },
                                      "x": 0.23219241000000002,
                                      "y": 0.07395723500000001
                                    }
                                  }
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6FiFPLYz2OKcpHrn8qr3MJkIIAOM+n4HJ7D071HLbM+0gLlQB2H6FWGPT6mkPzLu4etI3I4ODWeLR+4XA7EjB7dkB/WlNo+f4cZ9v5bOw70xFxQ+eWBHpipqqfY1ByCRjpwvH/jtW6AKrfePX/vo/wAs03GOcn/vpv8AGrBjBOeaaYgByTQBFj/e/wC+m/xpBz/e/wC+j/jQskTvsDAt7EHPc/kMfnU/lD1NADBIQP8AJqemFVUZPQdyfSoftkXqfyP+FAEpmQHBZQR7iqAvgGdWI4b5fmGMY9fc569qvNbxMclFJPcqP8KT7ND/AHE/75H+FAGJFLGkgeXbuHI2kYHsAD7n+Zq9Behiod15zuwRj2xk/Tnuc8Vd+yw/3E/75H+FJ9lh/uJ/3yP8KVh377Ec8kcqFQ65P+0O341WCS/3T+Yq99lh/uJ/3yP8KmAxwKTinuCdj//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3246480193052542292",
                              "shortcode": "C0N0Ij1PQVU",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/404046322_902015158113556_6148250319976907347_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=n_BpnzqrL7YAX8LC0r1&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzA1MjU0MjI5Mg%3D%3D.2-ccb7-5&oh=00_AfCLJsKRuwsHKUmmHmF15FrOy_SUJ09umPEiNIJFtXIPpg&oe=657536FC&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq33Yo3c5+mOPr60glI7E/98/40TdR1/AGot3sfyNAEwm5xtIz7r/jUhYHjODVXI/2v++TTsg/3uf9k0APVTn75PtVioVQA5BqagCrOWBG0A/U4qNdx6hQB7k1KZFlGU5puCKAEwR/d/Wlwf8AY/8AHqXn/IoGe/A/L9aAHRg5H3fwzViokBz0x+P9KloAzrXEJbzGVSf4dw4+vPvUs88bLtDKSSP4h/jUzW8bHJRST3Kj/Ck+yw/3E/75H+FK3Qd+pBBLHGSpdSOoO4fj34pZ542QruQgj1X/ABqX7JD/AM80/wC+V/wo+yQ/880/75X/AApgNiljRcb1P/Ah/jVqoPssP9xP++R/hU1Aj//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3246480193052705565",
                              "shortcode": "C0N0Ij1P4Md",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/404286436_386686050454743_5369242887636839144_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=103&_nc_ohc=XDft5eCrdbMAX8r2upN&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0NjQ4MDE5MzA1MjcwNTU2NQ%3D%3D.2-ccb7-5&oh=00_AfD-08ifQn4PHZo7uY-2rfLvz2HhJjHhYaMCb6qrag4Aiw&oe=65742D80&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6Pa2Sc8emBxSgHuc0jKWxgkY9Mc/mDVaWRYfvuw/L/4mgC5SVS80ZA3tzjjjv0/h709CGbaHbI6jK9+RninZiumTASZ5IxUtRrGQc7mPscf0AqSkMKo3kZfGF3YIPXHTofwq9Ubyon3mA+pFAWvsZ22XOSnofvdSOnaprWIx5+Urk565/X296d9tQfxJj/e/+tThfQE43inzAqcuif3Mt0UgIIyOQaWkBFOrOjKpwxBwfesWLTpud20E45LHIx9P8a36Klq5rGo4JpW11+4xhpbEYZx+v+NOGkJ3Y/gB/XNa9FHKivbT7/kRxRiJAgyQoxzUlFFUYvXVn//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          }
                        ]
                      }
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3243751224846985141",
                      "shortcode": "C0EHo2Ivie1",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCd6Mu8jEOufYD8QgwzKp-RCMZRKTM3aygieB3p8WdxUA&oe=6571E403&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpnWLnrlf++RR/bNz6r/3yKy6SgDUGsXIOcjP+7RWZRQAAFjgck9q0BFDjkHP0NUASpyDgjvUnnyf3m/Ok1cqMuXon6q4xxg+np9O1FIzFzljk+popkiYop1FADaKdRQB/9k=",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjQzNzUxMjI0ODQ2OTg1MTQxIn0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/404787231_3693588950963364_7447920868781947035_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=Qk9jA2gPW5kAX_WZcii&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAemB-fmoC9JBmta95Uk24gIZnkTnzuFi_ZVunsgNFGeQ&oe=65714476&_nc_sid=8b3546",
                      "video_view_count": 182,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟\n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara Periode 18 - 24 November 2023. \n\nSecurity Information\n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 1
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1700905357,
                      "edge_liked_by": {
                        "count": 8
                      },
                      "edge_media_preview_like": {
                        "count": 8
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBsgr7b6Hnpr7e0XW1Ib0-LTmdRmkBz9GYDnM_BJESX4A&oe=6571E403&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCVePGou-lcdW8ktU1cKeaQzu-Cbh9pYf284yYAtOkSOA&oe=6571E403&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDSGCjBsXEiGqUdbOT7xDWPMBOQwVaNczoJfnX3uyegRg&oe=6571E403&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBZPrwcugGoQrSuZlQGX3Z16B8WXERN7c7O2S03feDV8w&oe=6571E403&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBsgr7b6Hnpr7e0XW1Ib0-LTmdRmkBz9GYDnM_BJESX4A&oe=6571E403&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/405236446_651928903755026_556983089290880153_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=gS-bA06T_N0AX90UV6J&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBsgr7b6Hnpr7e0XW1Ib0-LTmdRmkBz9GYDnM_BJESX4A&oe=6571E403&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphImage",
                      "id": "3240078921416115537",
                      "shortcode": "Cz3EpzDPQVR",
                      "dimensions": {
                        "height": 1309,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=dst-jpg_e35_p1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2-ccb7-5&oh=00_AfBJcd0_cm722XGzNshnn6pvtoKVJCmTpnU1wg9ATvct4A&oe=65759E15&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.23788315000000002,
                              "y": 0.03230786
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ACMq0/to/unnn7w/xpwv/wDZ/wDHl/xquLVjwACR/tHjt/dpTayf3B/32f8ACouzr5afl9//AASaLUlkcJgjPHarbyR5wWwR2B5/Ic1kpZ3AcHoAQfvA4GauzXUCMQRvYddq5x9T/wDXppvqZ1IxTXJqutncvKQQCOR60VTW/gwOSvtsbj9KKoxJdpYnB6H3/wAKURH1prRsSf8AGk8tv8mgQ+RWEbBPv4OPr2rnoIzGckkscggdOv0PtW+IdwKt90jBHqDVN7MpwPu9eFJ56f3s9PWkUnuQCGRxlWIB7ZP+NFPFvMPuqcf8AH6c4/OilYvnfl9xbMZJ4IoELU4AeZ+JqZQNv4f0q7mNhI48Aj1zyOOtRiM52MWb/a6cZyBkHsOM9/XmrAAxTcCkMlopABRQB//Z",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗛𝗢𝗔𝗫 𝗢𝗥 𝗙𝗔𝗖𝗧 #17\n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀\n\nSemangat Sore Sahabat Daihatsu,\n\n𝗞𝗣𝗨 𝗕𝗮𝘁𝗮𝗹𝗸𝗮𝗻 𝗣𝗲𝗻𝗲𝘁𝗮𝗽𝗮𝗻 𝗚𝗶𝗯𝗿𝗮𝗻 𝗥𝗮𝗸𝗮𝗯𝘂𝗺𝗶𝗻𝗴 𝗥𝗮𝗸𝗮 𝘀𝗲𝗯𝗮𝗴𝗮𝗶 𝗖𝗮𝘄𝗮𝗽𝗿𝗲𝘀\n\nMasih seputar isu hoaks terkait Pemilu Pilpres 2024, salah satu isu yang beredar adalah viralnya unggahan video di media sosial yang mengeklaim Gibran Rakabuming Raka batal menjadi Cawapres. Bagaimana faktanya? Yuk, simak berita selengkapnya pada gambar di atas, agar kita terhindar dari berita hoax. Sahabat, waspada hoax, saring sebelum sharing!\n\nSumber : EA Department\n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#Hoax\n#Fact\n#Facts\n#StopHoax\n#Disinformasi\n#PemiluSerentak2024\n#Pemilu\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#JakartaUtara\n#Karawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1700467528,
                      "edge_liked_by": {
                        "count": 19
                      },
                      "edge_media_preview_like": {
                        "count": 19
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfA015vJ--aHQnyQdpby59qpw1L2FHdqezR9n6FyOSFfjg&oe=65759E15&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfC1jAsR-8F5sSK83nPJNgI4fO3ONsbt9T8IUIZE3IcBnQ&oe=65759E15&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfD5TtJs66PnZDnf3EShhc7B2QuCjEEsYo_EGDL8zOddxg&oe=65759E15&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfBaIMZhoaOGQ_MRuk1YwkMh6icq9DPolh0qEwth2aq2ew&oe=65759E15&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfB-n9cqHnIwRh11eQ8FyQ_hzC26d3Z_KJ-ENt07Cda0yQ&oe=65759E15&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403771276_985342842566016_2516287753318816309_n.heic?stp=c0.153.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=jJn64JGocvIAX9agPTF&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzI0MDA3ODkyMTQxNjExNTUzNw%3D%3D.2.c-ccb7-5&oh=00_AfA015vJ--aHQnyQdpby59qpw1L2FHdqezR9n6FyOSFfjg&oe=65759E15&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3238670335293179772",
                      "shortcode": "CzyEYK_vsd8",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDLxeUR0iybGsVufS5a284Pid2NjqBHJxjsnhFR1rbQKw&oe=6571A752&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpHWLnrlf++RS/wBs3Pqv/fIrLpKANQaxcg5yM/7tFZlFAAAWOByT2rQEUOOQc/Q1QBKnIOCO4qTz5P7zfnSauVGXL0T9VcY42n09Pp2opGYucscn1NFMkTFFOooAbRTqKAP/2Q==",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjM4NjcwMzM1MjkzMTc5NzcyIn0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/404036113_1791074601323584_7022892364738699406_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=xiabYET_hOwAX85hAze&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAPyIyOHIH3GViXc769OQoSy94Qt4nZOkqog9J6xtlVTw&oe=65716227&_nc_sid=8b3546",
                      "video_view_count": 198,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟\n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara Periode 10 - 17 November 2023. \n\nSecurity Information\n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1700299683,
                      "edge_liked_by": {
                        "count": 5
                      },
                      "edge_media_preview_like": {
                        "count": 5
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBU1aX5kzMRHbFkGurXplCjnt0rhe9B8lpRis0AYNpBbg&oe=6571A752&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAfqm9isS0BT-Xs0xft8fZKVXz6jJ9mlrBa_fdHnoDOpQ&oe=6571A752&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfA6MdC7jgeuqgFCkUbIdVswzLIrxdDEz5qf6ctpKHxR4w&oe=6571A752&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfChl1IpbfNJUOmKNoiQ4E3SyRiK_DlkmLTP_zVNiPOrtw&oe=6571A752&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBU1aX5kzMRHbFkGurXplCjnt0rhe9B8lpRis0AYNpBbg&oe=6571A752&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/403421092_242923145463796_1393575821160731481_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=68PA-8LIJSEAX8iaT56&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBU1aX5kzMRHbFkGurXplCjnt0rhe9B8lpRis0AYNpBbg&oe=6571A752&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphImage",
                      "id": "3236411862576543063",
                      "shortcode": "CzqC3EXvDVX",
                      "dimensions": {
                        "height": 1303,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=dst-jpg_e35_p1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2-ccb7-5&oh=00_AfAGnZRQv0t6qvLmQgrFO_g2bjcPo921ARYeO8MtbIfP2w&oe=65758E1B&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.20217732,
                              "y": 0.05174425
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ACMq6FxtBIBJ9BmmSu8YyMbeMcEn9D+tRO4DHhj9FJH50iy46Bx/wE0roqzBLiRztAx7lWx/Op87ztYdPTI/H8fTNO2n1NLsPrTE/IeBgYFFAooEVbkgYyQOvU4qtlf7y/8AfVSXgXIznv0x7etU8J/tfmtZunzO+pLm1poXEKjow/OrbfeHI+lZarGT/F+lX59qkM2fTjp+NOMOT5jUubctUVWN3COC6g+hOKKsZBeiQkbBnr2B9PWqO2f0P/fK/wCFXwoMnQdTU6ou3oOnp7UreZaklpyp+qMoLcA9D/3yv+Fa027jaM880qgYNNwKLeYOV+iXoifAopoAxRTIP//Z",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "#𝗦𝗘𝗖𝗨𝗥𝗜𝗧𝗬 𝗧𝗜𝗣𝗦 #60\n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀 \n\nSemangat Siang Sahabat Daihatsu, \n\n𝗧𝗶𝗽𝘀 𝗣𝗲𝗺𝗶𝗹𝘂 𝟮𝟬𝟮𝟰 𝗕𝗮𝗴𝗶 𝗚𝗲𝗻-𝗭 \n\nCalon anggota legislatif sudah mulai nih menargetkan Gen-Z sebagai penyumbang suara, karena mereka adalah kelompok yang semakin aktif dalam pilihan politik. Biar gak salah pilih, kali ini tim @kliniksecurity akan berbagi tips bagi Gen-Z mengikuti Pemilu 2024. Tips selengkapnya pada gambar di atas ya, Sahabat. Semoga bermanfaat :)\n\nSumber : EA Department \n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id \n\n#SecurityTips \n#Tips\n#PemiluSerentak\n#Pemilu2024\n#Informasi\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#JakartaUtara\n#Karawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1700030380,
                      "edge_liked_by": {
                        "count": 13
                      },
                      "edge_media_preview_like": {
                        "count": 13
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfAzeVdcECevbrf3rwziRIA_HKgqW-wRIWcCr41gX9frlg&oe=65758E1B&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfCm4OuL2zrnseTiCrOuxDxvE_aP9uuHD__lMZr3e8Vg0w&oe=65758E1B&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfDCwtvXYkXvqEJojFzjBJKOtSJLZlddQFYJ07wnI7Pvsw&oe=65758E1B&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfAW2R2XLlDHq8qNtz2wQeuxk6EZMma32fmHb1xhBbNy2w&oe=65758E1B&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfD6WinAg_8tI0-4phzs_mDhQbQMcihTzAf17rDctmbjKg&oe=65758E1B&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/402198177_1013180363270471_2674768561480548569_n.heic?stp=c0.149.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=111&_nc_ohc=wUgKmbjF2CEAX_1hdp8&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzNjQxMTg2MjU3NjU0MzA2Mw%3D%3D.2.c-ccb7-5&oh=00_AfAzeVdcECevbrf3rwziRIA_HKgqW-wRIWcCr41gX9frlg&oe=65758E1B&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3233541851604394258",
                      "shortcode": "Czf2S6XPSES",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAMsjbxflT8cdCsP9I0Z5yXRAJ4sfrR5O8C6WQiFPrOQw&oe=657176E8&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpnWLnrlf++RR/bNz6r/3yKy6SgDUGsXIOcjP+7RWZRQAAFjgck9q0BFDjkHP0NUASpyDgjvUnnyf3m/Ok1cqMuXon6q4xxg+np9O1FIzFzljk+popkiYop1FADaKdRQB/9k=",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjMzNTQxODUxNjA0Mzk0MjU4In0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/398595431_863950155364992_7298087416211698458_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=BbyCq4NSlvMAX8RGqTI&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAPBJ-mXBxTIpORvICGvmveC5yfmvNF0u_Xo7g3VWhl2g&oe=65716473&_nc_sid=8b3546",
                      "video_view_count": 239,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟\n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara Periode 05 - 09 November 2023. \n\nSecurity Information\n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1699688381,
                      "edge_liked_by": {
                        "count": 6
                      },
                      "edge_media_preview_like": {
                        "count": 6
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC44NLa-NJxPseXxPhk5LDrDklFZSjkWpso5H9uYtFRvA&oe=657176E8&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBkYULv6Dwiy3UTukNqrjldAlmX6L9OtjWGUYea8z2Azw&oe=657176E8&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCjEjM0pNjTZJPTZNRapBCeMyeRT5WtA3CzxmIFBbZTCg&oe=657176E8&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAneHrXU7VNzOcvFL7Jd1IigGHUJU3nyA6NGfvTt-eQKQ&oe=657176E8&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC44NLa-NJxPseXxPhk5LDrDklFZSjkWpso5H9uYtFRvA&oe=657176E8&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400762199_871877394608141_7246858680370726029_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=aUYypJQmnE4AX-5xFSi&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC44NLa-NJxPseXxPhk5LDrDklFZSjkWpso5H9uYtFRvA&oe=657176E8&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphSidecar",
                      "id": "3231406299233068410",
                      "shortcode": "CzYQuiOvyV6",
                      "dimensions": {
                        "height": 1080,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfAyFArdb2CdyTOBYIO0_CPusMZZEDClOPXmgJg73xwvgQ&oe=6573FE66&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.253469,
                              "y": 0.056371957
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": null,
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗡𝗘𝗪𝗦𝗣𝗔𝗣𝗘𝗥 \n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀\n\nSemangat Sore Sahabat Daihatsu,\n\n𝗝𝗲𝗹𝗮𝗻𝗴 𝗣𝗲𝗺𝗶𝗹𝘂 𝟮𝟬𝟮𝟰, 𝗪𝗮𝘀𝗽𝗮𝗱𝗮𝗶 𝗧𝗶𝗴𝗮 𝗔𝗻𝗰𝗮𝗺𝗮𝗻 𝗜𝗻𝗶\n\nJelang Pemilu 2024, kita harus mewaspadai beberapa ancaman yang dapat terjadi agar penyelenggaraan Pemilu berjalan aman dan damai. Apa saja ancaman tersebut? Sahabat, simak berita selengkapnya pada gambar di atas. \n\nSumber : EA Department \n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#Newspaper\n#PolitisasiAgama\n#Hoaks\n#PemiluSerentak2024\n#JakartaUtara\n#Karawang\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1699433670,
                      "edge_liked_by": {
                        "count": 12
                      },
                      "edge_media_preview_like": {
                        "count": 12
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfDyo1cmbQbqEpfc5vBDWF5FQ9xQIoyaZMGm7VGkTHr2zw&oe=6573FE66&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfB7WwuqwVabR_2ixSQ_OqUj8VSJLcVMN71HfDcgADnl0g&oe=6573FE66&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfBAnfLH_R1j8jEvIOfjShlNqkfgFh83N7u3pTEqj6GLFA&oe=6573FE66&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfAhEY37qpyG5XI5wbk4IfsBwLkbsw_AH6OndfV8ii79hg&oe=6573FE66&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfDbatSHl6MXT9qjkXjuxg-W5e153XJcbgdW9_CvBqg6sA&oe=6573FE66&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfDyo1cmbQbqEpfc5vBDWF5FQ9xQIoyaZMGm7VGkTHr2zw&oe=6573FE66&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "edge_sidecar_to_children": {
                        "edges": [
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3231406295147843392",
                              "shortcode": "CzYQuebP49A",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399423878_1469874826915709_575666016172523332_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=HruDeTboUUAAX-mAvBC&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE0Nzg0MzM5Mg%3D%3D.2-ccb7-5&oh=00_AfAyFArdb2CdyTOBYIO0_CPusMZZEDClOPXmgJg73xwvgQ&oe=6573FE66&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  {
                                    "node": {
                                      "user": {
                                        "full_name": "PT Astra Daihatsu Motor",
                                        "followed_by_viewer": false,
                                        "id": "5785282780",
                                        "is_verified": false,
                                        "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                        "username": "sahabatadm"
                                      },
                                      "x": 0.253469,
                                      "y": 0.056371957
                                    }
                                  }
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6EkKeWxnscU4EDknOfpVe5hMhBABxnsPwOT2Hp3pksDPsGBgDB4XA6c4I+vApD8y5uA7jn3prMCDgge/FVVsgO4x3GxcH9PwoFkACARg9PkXsc/j/wDXpiLCByc7gR7CpqqLbMn3H2+uFXn9KtAEDBOT6+tAFVwNxP8AU/403Yvp/P8AxpJZkRyG3Z+nH59P/r1GbqJf735UrlcreyJ1Oz7v+fzp/mGpBGBTXCRrubgDvTJGeYasVXLx9sHPp0/zz0pDewKcF1BHBGRxQAyUjcfmA9tw/wAajJUggsOevzD/ABq21vExyUUk9SVH+FJ9lh/uJ/3yP8KAImn5+V49vueen19acJkYYdoyPqOv4077JD/zzT/vlf8ACj7JD/zzT/vlf8KAKgeKDIQ7sku2Cp6np1/IDsKuBMjPHPtSfZYf+eaf98j/AAqcDHAoA//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3231406295265258247",
                              "shortcode": "CzYQueiPysH",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/399539835_351949317226833_2105001918534434382_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=6_eRmGI3dfAAX_55Ypf&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTI2NTI1ODI0Nw%3D%3D.2-ccb7-5&oh=00_AfDDdJ_DhkWrVNTayLYdOfo3sBKJHw7paDGbmpySA3XcOA&oe=657530E5&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6FjtOSTz2xn+QpomUdSf++T/AIUkxAIyQPrUQkXruX35P+FAFsMCMjvQeRVMun95fz/+tS7l9R+v+FAEwjbPLE+3FT1Wi2scgg49Ks0AQSrk5xnj0zUXl5/hHr93/wCtTmZZQGHIIyOP1/wpmxeuOfpQBJ5R9B+Qp21+lQ7F9P0qUu3+RQA9Q2eelS1CrMW9vpU1AFG6lCLhWAI4IyAfy/8A1VUjuH+cFsbclcsDu9hz37ccdK02t4mOSiknuVGf5Un2WH+4n/fI/wAKm2t7lc2lrFWS5cIvltGWx825hnOPqO9Ecp8pQ0ih8fMcqefTr29RVn7JD/zzT/vlf8KPskP/ADzT/vlf8KoVyF5CRhZUB9eP8ab9nuP+elWPssP/ADzT/vkf4VPQtBPU/9k=",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3231406295156065462",
                              "shortcode": "CzYQuebvQS2",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/400089688_181039814998929_5231261478895838488_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=f2OG6bHBeXYAX9rb_dZ&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIzMTQwNjI5NTE1NjA2NTQ2Mg%3D%3D.2-ccb7-5&oh=00_AfB3dNpwLOZBdx0Pcta83X94bBXaTelW-lDcaTin5Qsshg&oe=65743796&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6Pa2Sc8emBxSgHuc0jKWxgkY9Mc/mDVaWRYfvuw/L/4mgC5SVS80ZA3tzjjjv0/h709CGbaHbI6jK9+RninZiumTASZ5IxUtRrGQc7mPscf0AqSkMKo3kZfGF3YIPXHTofwq9Ubyon3mA+pFAWvsZ22XOSnofvdSOnaprWIx5+Urk565/X296d9tQfxJj/e/+tThfQE43inzAqcuif3Mt0UgIIyOQaWkBFOrOjKpwxBwfesWLTpud20E45LHIx9P8a36Klq5rGo4JpW11+4xhpbEYZx+v+NOGkJ3Y/gB/XNa9FHKivbT7/kRxRiJAgyQoxzUlFFUYvXVn//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          }
                        ]
                      }
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3228480260454253798",
                      "shortcode": "CzN3bEQvITm",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCln7Alz70lCg7QRjGjvgxLUunVtfGSrowm_aBSaWa3BQ&oe=65719A40&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpnWLnrlf++RR/bNz6r/3yKy6SgDUGsXIOcjP+7RWZRQAAFjgck9hWgIoccg5+hqgrFTkHBHepPPk/vN+dJq5UZcvRP1VxjjB9PT6dqKRmLnLHJ9TRTJExRTqKAG0U6igD//Z",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjI4NDgwMjYwNDU0MjUzNzk4In0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/398812272_800653801862445_5941502621218781291_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=44qhwGLpK8AAX_A69HM&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfA5dPj7z4XwJuHWsO1lIrzCv8URK2vtjPYZxPe3YpOsTw&oe=657183A8&_nc_sid=8b3546",
                      "video_view_count": 261,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟\n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara periode 28 Oktober - 04 November 2023. \n\nSecurity Information\n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1699084999,
                      "edge_liked_by": {
                        "count": 13
                      },
                      "edge_media_preview_like": {
                        "count": 13
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDwK5itSV_nFlnwwsFgxKN8gycAAnFSvLdpc66h0tMBwg&oe=65719A40&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDdEdxWM1a1zH0E6Pp1vwkv8iVNLiIdpAgX0tv5ZARLQw&oe=65719A40&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAPVg53VmYn4xKicmkB0EvZQ8wv_MgazX0N0_OkGIAHaQ&oe=65719A40&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfA1Jj9kMOjc6LiGRgvlagLGdxtPHfTGa25hg3kr6X1kZQ&oe=65719A40&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDwK5itSV_nFlnwwsFgxKN8gycAAnFSvLdpc66h0tMBwg&oe=65719A40&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/398328953_897518851813170_2046083675329092949_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=QsNfu8SHY9oAX831rx_&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDwK5itSV_nFlnwwsFgxKN8gycAAnFSvLdpc66h0tMBwg&oe=65719A40&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphImage",
                      "id": "3224833004551293637",
                      "shortcode": "CzA6IggPErF",
                      "dimensions": {
                        "height": 1311,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=dst-jpg_e35_p1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2-ccb7-5&oh=00_AfBVOmV4FWG5txrSFWCNaRN0QeADPKYAoXxGWFPwWkgzHw&oe=6574E9AB&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.23702689999999998,
                              "y": 0.04526545
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ACMq33kjjOGYKTzgn+lL56bSwyQuM8ev1xSEjJyN31xSZTGNoweooHp8xPtSYzz+n+NMa4Rufm9OP/104IhONo5qNZJFAACY7YY4oC1y6OBRTUYlQTjPtyKKBEWcE55/AUu8elNbdu6jGf7v9d1P3L6UAJvHpTVt48Zxjr3P+NSb1HamSMOMkjnp6+3v9KAIxconyqrED0HFFWwcjNFAEEh2np796cygDIGeneogo39O5qUKMdO1ICL5iMn5c445JH196dLCkpBYj5enSpQBSbR6CgBwIA6iilAFFMD/2Q==",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗛𝗢𝗔𝗫 𝗢𝗥 𝗙𝗔𝗖𝗧 #16\n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀\n\nSemangat Siang Sahabat Daihatsu,\n\nKominfo mencatat isu hoaks terkait pemilu terus meningkat. Tahun 2022 hanya 10 isu, meningkat menjadi 98 isu selama 2023. Salah satu isu hoaks yang beredar adalah viralnya foto Surat Suara Pilpres di medsos. Simak berita selengkapnya pada gambar di atas, agar kita terhindar dari berita hoax. Sahabat, waspada hoax, saring sebelum sharing!\n\nSumber : EA Department\n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#Hoax\n#Fact\n#Facts\n#StopHoax\n#Disinformasi\n#PemiluSerentak2024\n#Pemilu\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#JakartaUtara\n#Karawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1698650073,
                      "edge_liked_by": {
                        "count": 8
                      },
                      "edge_media_preview_like": {
                        "count": 8
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfDRffKCf0c2pqdCciBZW7iI-95ppd3Wh9AtUaOZFYhMMQ&oe=6574E9AB&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfDViPa3BEgmmh0w3M4xkEcjpn5BqUJvDry9tQ2oGcw9_w&oe=6574E9AB&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfAVgWksc4vxDJG5c1FbSaRUfSUB4XRIbAn_HTO4b-h7LQ&oe=6574E9AB&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfB-GQSATVFpfTRHR-IPD0cqIxcXcC5nh4VWRUf0tq3YKA&oe=6574E9AB&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfBGwM1iwxzqMkSvkxvcLEy5E8F942wFkIBgLP6ygOQX9A&oe=6574E9AB&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396675597_655083223432726_6243390833078891035_n.heic?stp=c0.154.1440.1440a_dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=8NgLJdHOvuAAX9-7oZx&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyNDgzMzAwNDU1MTI5MzYzNw%3D%3D.2.c-ccb7-5&oh=00_AfDRffKCf0c2pqdCciBZW7iI-95ppd3Wh9AtUaOZFYhMMQ&oe=6574E9AB&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphVideo",
                      "id": "3223432097703966147",
                      "shortcode": "Cy77moVPLXD",
                      "dimensions": {
                        "height": 853,
                        "width": 480
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAb3CMZ2C1J87pWLGwPjj5o1HED3XoXfyDr5R7aVhS1Hw&oe=6571E252&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": "ABgqpnWLnrlf++RR/bNz6r/3yKy6SgDUGsXIOcjP+7RWZRQAAFjgck9q0BFDjkHP0NUASpyDgjvUnnyf3m/Ok1cqMuXon6q4xxg+np9O1FIzFzljk+popkiYop1FADaKdRQB/9k=",
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": true,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "dash_info": {
                        "is_dash_eligible": false,
                        "video_dash_manifest": null,
                        "number_of_qualities": 0
                      },
                      "has_audio": true,
                      "tracking_token": "eyJ2ZXJzaW9uIjo1LCJwYXlsb2FkIjp7ImlzX2FuYWx5dGljc190cmFja2VkIjp0cnVlLCJ1dWlkIjoiYzY2MjI3MjA1NDI1NDU3MmIzOTM3MmEwMmQzZDVjZDgzMjIzNDMyMDk3NzAzOTY2MTQ3In0sInNpZ25hdHVyZSI6IiJ9",
                      "video_url": "https://scontent-cgk1-2.cdninstagram.com/v/t50.2886-16/395842560_363171879479288_2520427856760125821_n.mp4?_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=108&_nc_ohc=8V3K6qtcxW8AX-LMUS3&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCZhO6bE8UHg6RZwD8Af6ZkIs8Oxw5MmpTDL-MYgWKDvQ&oe=6571AF61&_nc_sid=8b3546",
                      "video_view_count": 225,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "𝗞𝗜𝗟𝗔𝗦 𝗞𝗥𝗜𝗠𝗜𝗡𝗔𝗟\n\nRangkuman berita-berita kriminal seputar Karawang dan Jakarta Utara periode 21 - 27 Oktober 2023. \n\nSecurity Information\n\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#KilasKriminal \n#Kriminalitas\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#Karawang\n#JakartaUtara\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1698483129,
                      "edge_liked_by": {
                        "count": 7
                      },
                      "edge_media_preview_like": {
                        "count": 7
                      },
                      "location": {
                        "id": "214427142",
                        "has_public_page": true,
                        "name": "Jakarta, Indonesia",
                        "slug": "jakarta-indonesia"
                      },
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCxz_ZqTbhkkQvY8KIG1Z_Xpg-F0TgtcVhmXMU3yibHqw&oe=6571E252&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBvieVpKlQbm6Wmyd29jMJq5MacDdInjCPgNAuHrxCsZA&oe=6571E252&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfASjWpPfgqfnV9h-Ul7_VW-98poA32sBjhGRB_mCqNGrA&oe=6571E252&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAWpvQRMfKg0qLDVVzrZ9QC2Pmvcdk-J0WlOHPrWoVyjw&oe=6571E252&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCxz_ZqTbhkkQvY8KIG1Z_Xpg-F0TgtcVhmXMU3yibHqw&oe=6571E252&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/396574911_1093358494985328_2346069201736561681_n.jpg?stp=c0.162.418.418a_dst-jpg_e15&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=wGekYg7_gjAAX8_Tfwb&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCxz_ZqTbhkkQvY8KIG1Z_Xpg-F0TgtcVhmXMU3yibHqw&oe=6571E252&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "felix_profile_grid_crop": null,
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "product_type": "clips",
                      "clips_music_attribution_info": null
                    }
                  },
                  {
                    "node": {
                      "__typename": "GraphSidecar",
                      "id": "3220423855407199815",
                      "shortcode": "CyxPm8XvXZH",
                      "dimensions": {
                        "height": 1080,
                        "width": 1080
                      },
                      "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfBNDfk85KdH30ClIqx0l32x3l7m0axT9y_QD9uXrFGwSw&oe=657561A2&_nc_sid=8b3546",
                      "edge_media_to_tagged_user": {
                        "edges": [
                          {
                            "node": {
                              "user": {
                                "full_name": "PT Astra Daihatsu Motor",
                                "followed_by_viewer": false,
                                "id": "5785282780",
                                "is_verified": false,
                                "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                "username": "sahabatadm"
                              },
                              "x": 0.22756706000000002,
                              "y": 0.07580832400000001
                            }
                          }
                        ]
                      },
                      "fact_check_overall_rating": null,
                      "fact_check_information": null,
                      "gating_info": null,
                      "sharing_friction_info": {
                        "should_have_sharing_friction": false,
                        "bloks_app_url": null
                      },
                      "media_overlay_info": null,
                      "media_preview": null,
                      "owner": {
                        "id": "5610573356",
                        "username": "kliniksecurity"
                      },
                      "is_video": false,
                      "has_upcoming_event": false,
                      "accessibility_caption": null,
                      "edge_media_to_caption": {
                        "edges": [
                          {
                            "node": {
                              "text": "#𝗦𝗘𝗖𝗨𝗥𝗜𝗧𝗬 𝗧𝗜𝗣𝗦 #59\n𝗘𝘅𝗲𝗰𝘂𝘁𝗶𝘃𝗲 𝗡𝗲𝘄𝘀!\n\nSemangat Siang Sahabat Daihatsu, \n\n𝗠𝗲𝗻𝗷𝗮𝗱𝗶 𝗣𝗲𝗺𝗶𝗹𝗶𝗵 𝘆𝗮𝗻𝗴 𝗕𝗶𝗷𝗮𝗸 𝗽𝗮𝗱𝗮 𝗣𝗲𝗺𝗶𝗹𝘂 𝟮𝟬𝟮𝟰? 𝗜𝗻𝗶 𝗖𝗮𝗿𝗮𝗻𝘆𝗮!\n\n\"Pemilu Damai 2024\" merupakan salah satu upaya yang mendorong kita sebagai masyarakat agar dapat memilih pemimpin bangsa secara bijak dengan tetap menjaga perdamaian. Bagaimana menjadi pemilih pada Pemilu 2024 yang bijak? Ikuti berita lengkapnya pada gambar di atas ya, Sahabat. Semoga bermanfaat :)\n\nSumber : EA Department\n\nSecurity Information\nEA Dept. - GA Div.\nPT Astra Daihatsu Motor\nInstagram : http://bit.ly/Instagram-KlinikSecurity\nTwitter : www.twitter.com/KlinikSecurity\nTikTok : www.tiktok.com/@kliniksecurity\nEmail : security.hotline@daihatsu.astra.co.id\n\n#SecurityTips \n#Tips\n#PemiluSerentak\n#Pemilu2024\n#Informasi\n#BeritaTerkini\n#SeputarSunter\n#InfoJakut\n#SeputarJakut\n#InfoKarawang\n#JakartaUtara\n#Karawang\n#KlinikSecurity\n#DaihatsuSahabatku\n#SatuIndonesia"
                            }
                          }
                        ]
                      },
                      "edge_media_to_comment": {
                        "count": 0
                      },
                      "comments_disabled": false,
                      "taken_at_timestamp": 1698124461,
                      "edge_liked_by": {
                        "count": 9
                      },
                      "edge_media_preview_like": {
                        "count": 9
                      },
                      "location": null,
                      "nft_asset_info": null,
                      "thumbnail_src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfDtRTZO1eNFZRWlK9LIeoGGvn19QtirPGJrNUpQE4LjxQ&oe=657561A2&_nc_sid=8b3546",
                      "thumbnail_resources": [
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfBk4K4Bo5h1rHXE9tTjVTsfi2uAJdubRe7tqcO-a9JDzQ&oe=657561A2&_nc_sid=8b3546",
                          "config_width": 150,
                          "config_height": 150
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s240x240&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfD4Pnv6SVHfNphm7qQED2Kmk89mvYeMDFHYqjkKaWKjrg&oe=657561A2&_nc_sid=8b3546",
                          "config_width": 240,
                          "config_height": 240
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s320x320&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfAqSN4MYsr6pGwupprlC6FyAy-5WLZ_Z_lVWaievp1aCw&oe=657561A2&_nc_sid=8b3546",
                          "config_width": 320,
                          "config_height": 320
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s480x480&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfBdHNhcEsCTr9Ol8YYmGCfyhZFZ7_7I0Z-q4SOLhxB03g&oe=657561A2&_nc_sid=8b3546",
                          "config_width": 480,
                          "config_height": 480
                        },
                        {
                          "src": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s640x640_sh0.08&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfDtRTZO1eNFZRWlK9LIeoGGvn19QtirPGJrNUpQE4LjxQ&oe=657561A2&_nc_sid=8b3546",
                          "config_width": 640,
                          "config_height": 640
                        }
                      ],
                      "coauthor_producers": [
                        
                      ],
                      "pinned_for_users": [
                        
                      ],
                      "viewer_can_reshare": true,
                      "edge_sidecar_to_children": {
                        "edges": [
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3220423851062039323",
                              "shortcode": "CyxPm4Uv5Mb",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394341396_261558706870625_422736148223272040_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=105&_nc_ohc=B80lGXKDWHkAX-cSUzv&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MjAzOTMyMw%3D%3D.2-ccb7-5&oh=00_AfBNDfk85KdH30ClIqx0l32x3l7m0axT9y_QD9uXrFGwSw&oe=657561A2&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  {
                                    "node": {
                                      "user": {
                                        "full_name": "PT Astra Daihatsu Motor",
                                        "followed_by_viewer": false,
                                        "id": "5785282780",
                                        "is_verified": false,
                                        "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/116153665_2323529844622330_6096167943537208648_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=lVlo5decdKQAX9t8rGm&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAB4Euqo_4ezvIJIHxGe5EXz__IY9eXHdqh3TZePgS8Vw&oe=65757458&_nc_sid=8b3546",
                                        "username": "sahabatadm"
                                      },
                                      "x": 0.22756706000000002,
                                      "y": 0.07580832400000001
                                    }
                                  }
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6Pac5yfpRkLwTyfXFRTb8jYO/NRXMJkZcDIGeynHT15/L8aALW9R3H50jOOgIBPSs37O6jhe2DgR5OOe/wDL2qZLPPP3Oc42oT7cgcdsfSgC0ofPLAj0x/8AXqaqK2QUhlbaQOoVfTHpVnyz/eb9P8KAIXUbif8AGm7R6fqf8asORGM5x9eR/jSxyBxwckdcZ/rSv0HbqVto64/n/jSjCnI6/j/Kp2lVTtPXGazWMjS+Z5rBQc7ABjaO2O/uf5UwL+9j0qeq012kSbmOARkcVVF5n+NfzFJuwJXLF3KgXG4A56ZANRWk0aggsOvdhVs28THJRST3KjP8qQ2sJ/gT/vkf4Ura3HfSxi6heYBZGGc7RgjIHf8ATP51jC6YIY85BOeTznj+eBV3U4kQDaoHzHoAKyto9KoksPdvJGI2O4L09celbcOjoyKzHkqCfqRWXHGv7o4HPXgc8mupj4UfQfyoA//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3220423851330357431",
                              "shortcode": "CyxPm4kvci3",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394623620_1396237511328240_3278716592875979354_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=YIKvqbMrUdEAX9AgLM2&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTMzMDM1NzQzMQ%3D%3D.2-ccb7-5&oh=00_AfAK3rbQJVmopbQ4lksU6TlmxtfFJQ0as-foLt8V55eOyQ&oe=6574F6E4&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6BiVP8Rz2AyKBLjqGP8AwGmzEAjJA+tR7l9V9etAE/mj0b/vk0CTdxhh7kGocrnqB+tGU/vDFAEqowOdxPtgVNUKJ0YHIqagCGUnIwcfjj+tMyf8np+tDgsBkAnHoDTNmP4R/wB8j/CgB2SP/wBf/wBejJ9fxz/9ek2ew/75H+FJs9hgf7IH9KAJUJzyR+f/ANep6rrHyCQMDvgVYoAgkmVeAyg+5HH4Zqq918wVCvI7sODnvz6fjVtreJjlkUk9yoz/ACpPssJ/gT/vkf4UCauMWdO7rn/eH+NVLyZGYfP8uG4Urjp3J7nt71d+yQ/880/75X/Cj7JD/wA80/75X/Cla5SdihYzrk7jgY43Op7+gx+ZrXqD7LD/AHE/75H+FTULQG76n//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3220423851196099893",
                              "shortcode": "CyxPm4cvS01",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/394562534_292672493683696_4035123813268448836_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=104&_nc_ohc=gpJS7mV675EAX-ppFy6&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTE5NjA5OTg5Mw%3D%3D.2-ccb7-5&oh=00_AfAcR4Pqer79rgyJ_M20C7ba859QzQEt-5-MQBw93hA_XA&oe=65758463&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq32dVY5bHt/kUomQfxZ/z9KY7fMecfiP5Zpm73H/fQ/xoAsLKr8Kc085I44NVd3uPzH+NAI7sB+P/ANegCZVcHlgR6Yx/Wpag8o+v6mpqAIGU7un6U0KfTn6f1pJFG4kgH8KbsX0GfXA/woAl2N7fpRsb2/Soti/3R+Q/wpRGD/CPyFAEuH/yamFQ5fH/AOqphQBBNIv3Qyg57kcfrURnUxlQ6hxx94f55HSp2t4mOSiknuVH+FJ9lhP8Cf8AfI/woBaalK2m8tGMjD2BdSfeoEvE8wICm1Tx8wx6DGemB6ZrT+yQ/wDPNP8Avlf8KX7LD/cT/vkf4UrF81220tenQrRXEQfarrwOm4Hj8+uf0q/1qH7LD/cT/vkf4VMBjgUyT//Z",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          },
                          {
                            "node": {
                              "__typename": "GraphImage",
                              "id": "3220423851061942499",
                              "shortcode": "CyxPm4Uvhjj",
                              "dimensions": {
                                "height": 1080,
                                "width": 1080
                              },
                              "display_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-15/395087562_315283831232679_382357615342909473_n.heic?stp=dst-jpg_e35_s1080x1080&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=103&_nc_ohc=M5wbENezYD0AX_WVGyM&edm=AOQ1c0wBAAAA&ccb=7-5&ig_cache_key=MzIyMDQyMzg1MTA2MTk0MjQ5OQ%3D%3D.2-ccb7-5&oh=00_AfD-ED_noiK6mjEd4vjXNxV_vhqMxixHkA59svAeM9WIFQ&oe=65749684&_nc_sid=8b3546",
                              "edge_media_to_tagged_user": {
                                "edges": [
                                  
                                ]
                              },
                              "fact_check_overall_rating": null,
                              "fact_check_information": null,
                              "gating_info": null,
                              "sharing_friction_info": {
                                "should_have_sharing_friction": false,
                                "bloks_app_url": null
                              },
                              "media_overlay_info": null,
                              "media_preview": "ACoq6Pa2Sc8emBxSgHuc0jKWxgkY9Mc/mDVaWRYfvuw/L/4mgC5RVHzRkDe3OOOO/T+HvT0IZtodsjqMr35GeKdmK6ZMBJnnGPxqWo1jIOdzH2OP6AVJSGFUbyMvjC7sEHrjp0P4VeqN5UT7zAfUigLX2M7bLnJT0P3upHTtU1rEY8/KVyc9c/r7e9O+2oP4kx/vf/WpwvoCcbxT5gVOXRP7mW6KQEEZHINLSAinVnRlU4Yg4PvWLFp03O7aCccljkY+n+Nb9FS1c1jUcE0ra6/cYw0tiMM4/X/GnDSE7sfwA/rmteijlRXtp9/yI4oxEgQZIUY5qSiiqMXrqz//2Q==",
                              "owner": {
                                "id": "5610573356",
                                "username": "kliniksecurity"
                              },
                              "is_video": false,
                              "has_upcoming_event": false,
                              "accessibility_caption": null
                            }
                          }
                        ]
                      }
                    }
                  }
                ]
              },
              "edge_saved_media": {
                "count": 0,
                "page_info": {
                  "has_next_page": false,
                  "end_cursor": null
                },
                "edges": [
                  
                ]
              },
              "edge_media_collections": {
                "count": 0,
                "page_info": {
                  "has_next_page": false,
                  "end_cursor": null
                },
                "edges": [
                  
                ]
              },
              "edge_related_profiles": {
                "edges": [
                  {
                    "node": {
                      "id": "2673548422",
                      "full_name": "Recruitment HPM",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/12534142_1085280058191546_383893009_a.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=23yGK2TRA8QAX9PFVzA&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAdKfqeqMPzvYpR4Tsmus90fXcAUUF3sWCrGdPgbpAhcA&oe=65744BD1&_nc_sid=8b3546",
                      "username": "recruitment_hpm"
                    }
                  },
                  {
                    "node": {
                      "id": "4047104359",
                      "full_name": "Koperasi Sigap Nusantara",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/345195906_506059758275311_3390950333414437665_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=9XVdn2CR5kgAX8wFkY2&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAI2wFcQ3QPa2hMdbf-LxTYPdiQpoW0GeAf2E8Y-48GjQ&oe=6575AF8E&_nc_sid=8b3546",
                      "username": "kopsigapnusantara"
                    }
                  },
                  {
                    "node": {
                      "id": "5785143563",
                      "full_name": "PT Dharma Poliplast",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/313487747_118443230889032_4133471396563991120_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=108&_nc_ohc=-uYu27XY7mYAX-h2Nqs&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC-jpWr2DTue06YsqaGGMPyGhL6BS3roWOk93ghtmYHgQ&oe=6574084B&_nc_sid=8b3546",
                      "username": "dharma_poliplast"
                    }
                  },
                  {
                    "node": {
                      "id": "39245754343",
                      "full_name": "Time to Change",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/110457254_721618358628955_9089619594249259669_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=1Zu-9iSrEeQAX_2qhdq&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCitbKQIsVYnHsE_V5ZHpHDq0cGwSj160erh3-5pMoSjw&oe=65742613&_nc_sid=8b3546",
                      "username": "aicc.official"
                    }
                  },
                  {
                    "node": {
                      "id": "51490889381",
                      "full_name": "PT Isuzu Astra Motor Indonesia",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/272245767_685646702819090_4438520288997021413_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=6xduc5TAyoIAX8YqVWU&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfCP-KRiAtYoGxHKHQEXbnh3NgTx0582vpfdvymkfdN74g&oe=65740FF1&_nc_sid=8b3546",
                      "username": "iami_career"
                    }
                  },
                  {
                    "node": {
                      "id": "7766984652",
                      "full_name": "Abdullah fanany sinulingga",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/399193607_7003489536339014_6019358075546122016_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=102&_nc_ohc=JSYVKHO01aMAX9MRf5A&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC7iVaaLu3WAs0URXAR1Sy_kw2DUg6INxFHE4fuHry8NQ&oe=65750A64&_nc_sid=8b3546",
                      "username": "abdullah_linggaaa"
                    }
                  },
                  {
                    "node": {
                      "id": "44220768981",
                      "full_name": "Standupindo Tegal",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/300297803_609833797334043_6485557249263084176_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=103&_nc_ohc=qZCSUSh8mhQAX8SKv_x&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAdVXC9jWCT-ieI-gYUEVNlChFv_0KcC6VpBrpKR36hIQ&oe=65744DED&_nc_sid=8b3546",
                      "username": "standupindo_tegal"
                    }
                  },
                  {
                    "node": {
                      "id": "37104704268",
                      "full_name": "PT Gaya Motor",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/347712041_2189470981250865_4499514931885025832_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=109&_nc_ohc=QVI0Vb07V9wAX8FUyrY&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfC4M3uNYmd0h5ONFt_eVjTLO7XmuTEtaZVgoIz5J8WuSQ&oe=6574E670&_nc_sid=8b3546",
                      "username": "gayamotor.id"
                    }
                  },
                  {
                    "node": {
                      "id": "705326249",
                      "full_name": "alexandra agnes clarissa",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/384780713_2556050101223862_3757024075146553269_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=106&_nc_ohc=yLrUsn5-pisAX_atreo&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBSahuoyWNjR-Mzp2fkgqNgD3gA-n9yOMhStU9vyKnSeQ&oe=657465E1&_nc_sid=8b3546",
                      "username": "clarissagnesz"
                    }
                  },
                  {
                    "node": {
                      "id": "58155295825",
                      "full_name": "Rosalia Indah Karir",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/346683104_939977743816402_2822241456310332933_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=xGbgkxLTyMkAX8DjTbn&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDc-n7H1V35SgSe1_ZxCeM5cVJQyhxJNiFNIKPqQKlKAw&oe=657465A1&_nc_sid=8b3546",
                      "username": "rosaliaindahkarir"
                    }
                  },
                  {
                    "node": {
                      "id": "6862371",
                      "full_name": "Jorge Damián Salgado",
                      "is_private": false,
                      "is_verified": true,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/358161799_937165804024402_4602332735707813_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=110&_nc_ohc=YWpUxUTn-0gAX-MYe9A&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfDNLuXBTOqOjs3Oc5aQW3vqIyP13hRssBxoxgqZUuAT3w&oe=6574A0A1&_nc_sid=8b3546",
                      "username": "damian_salgado"
                    }
                  },
                  {
                    "node": {
                      "id": "44854055042",
                      "full_name": "Kedbel",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/239446131_342774164214012_7864009743516846905_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=100&_nc_ohc=OHTe_pcPjRYAX9iUioW&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfBQaI46GBK-pHmVKv8SoPSAI18wMUr72gj3U4V3hd_kZg&oe=6574974F&_nc_sid=8b3546",
                      "username": "kedbeldotcom"
                    }
                  },
                  {
                    "node": {
                      "id": "8539435537",
                      "full_name": "𝘽𝙖𝙨𝙚𝙘𝙖𝙢𝙥_𝙎𝙪𝙢𝙗𝙞𝙣𝙜_𝙑𝙞𝙖𝙂𝙖𝙧𝙪𝙣𝙜",
                      "is_private": false,
                      "is_verified": false,
                      "profile_pic_url": "https://scontent-cgk1-2.cdninstagram.com/v/t51.2885-19/240404848_387126169475479_4924068086821405180_n.jpg?stp=dst-jpg_s150x150&_nc_ht=scontent-cgk1-2.cdninstagram.com&_nc_cat=107&_nc_ohc=y8fuBnQFALoAX-oh6Hy&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AfAcxdwEBWJvT1XRg0IsrCj6X16hOH54itak6szil4yHaQ&oe=65745905&_nc_sid=8b3546",
                      "username": "basecamp_sumbing_via_garung"
                    }
                  }
                ]
              }
            }
          },
          "status": "ok"
        }';

      $res = [
        'status' => '000',
        'content' => json_decode($res)
      ];
      
      $res = (object) $res;
      
      return $res;
    }
}