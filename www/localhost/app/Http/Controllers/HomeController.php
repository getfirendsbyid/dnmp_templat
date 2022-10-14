<?php

namespace App\Http\Controllers;

use App\Message;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Mime\Email;

class HomeController extends Controller
{

    private  $cookie = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDI1MjcyNDcuMTI3NzU1OSwiZXhwIjoxNjQyNTMwODQ3LjEyNzc1NTksInN1YiI6IllOVy5WSVAiLCJqdGkiOiIyMDIyMDExOTAxMzQwNyIsInZhbCI6ImxNZ2RBUUlBQUFBUVltWXlaVFEzTnpObE5UUTJZakUxTUJ4dmNYSTFielZDTFZWUmMySm1PR3BDYVc0M2NuZGZhVlpCYVUxRkFCeHZcclxuVlRJMldIUTROVFZGZUhSVlFYSnFSazVhT1ZJMFRFWktaR0l3RHpFeE55NHhOell1TVRnM0xqRTJNQUFBQUFBQUFBQT0ifQ.dQkwjJ1ykuaY5qtZN4grwgWcVb483Tf22z5RUU9yU6E";
    private  $zftsl = "71e17c0428956824bb88bd3edd5e9e45";
//    private  $body = "285fccd3d75ccae6f503d8e8a3f3cdf0f298c501e1a408023dbdc73b0f5adea4a8ea3c618634f698adb163a31fce28dfa8846f483799b6f95bc6c938576cf6a10fb59be41d7429a78b9876f7a6db806a8d78b649eff5411901f030968e18544165e006af8f44bac06d91ede1b621f544edd8efa5fcbdd11601b4535d70d4a231692cfcba1f1632f77765954e50b3b0fe79410157813e2e9236d5ec484e2c9e76505153dd69f785068c848a780b354dbf33715d31a7e7ffc8bc69a0d5c5add24e";
    private  $body = "779c396f06352fbfd16d3b55aaa613c9ee3324a169327f28199cb212c3cdc3a9e7938632efd356868fefbb22bd686f6ba5503b0e02e0bb63bdfb00adbc97eb8c5b1280ba4589cbcdccdfa6386e77f7efb2bd35077df413c862f66aea92a0034a2163dde7bfe5827f5a215bebad00c9538ece70a13a62d44c81409155ea57cb1686f930e8248baeb5792a4a63a4af3d729d2d48ae00499bb90d13cd83faeaebc7f7c5f0210c5e5d98ed6edca74ecdc553c842d8b6dabe7d34480917903420bf92";
    private  $key = "1b220231563a0ccc";

    private  $iv  = "1234567890000000"; // 偏移量
    private $options = 0;

    //https://cloud.cn2030.com/sc/wx/HandlerSubscribe.ashx?act=Save20&birthday=1993-08-12&tel=18384105359&sex=1&cname=%E4%BD%99%E5%A8%81&doctype=1&idcard=513821199308127657&mxid=lMgdAT6YAAAcZjQB&date=2021-12-28&pid=62&Ftime=1&guid=
    public function get()
    {
        // $this->ZM_Thread();
        $birthday = '1993-08-12';
        $tel = '18384105359';
        $sex = 1;
        $cname = "余威";
        $docType = 1;
        $idcard = "513821199308127657";
        $mxid = "lMgdAT6YAAAcZjQB";
        $date = "2021-12-28";
        $pid = 54; //疫苗id
        $ftime = 1;
        $cookie = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDA1ODkyMzEuMjQyNTIyLCJleHAiOjE2NDA1OTI4MzEuMjQyNTIyLCJzdWIiOiJZTlcuVklQIiwianRpIjoiMjAyMTEyMjcwMzEzNTEiLCJ2YWwiOiJsTWdkQVFJQUFBQVFOMlExTWpobFptSXdNbVl3TkRVeFloeHZjWEkxYnpWQ0xWVlJjMkptT0dwQ2FXNDNjbmRmYVZaQmFVMUZBQnh2XHJcblZUSTJXSFE0TlRWRmVIUlZRWEpxUms1YU9WSTBURVpLWkdJd0R6RXhNQzR4T0RVdU1qRTVMakU0TmdBQUFBQUFBQUE9In0.VVkJxNSSIlR4qZCgegFK3RFH-qBaDqPNj72mW47VArM";

        $zftsl = "e236b0dccc810f5fa8bc18d9be359347";
        $this->ZM_Thread($birthday,$tel,$sex,$cname,$docType,$idcard,$mxid,$date,$pid,$ftime,$cookie,$zftsl);
    }

    public function getStatus(){
        $this->ZM_getOrderStatus_get($this->cookie,$this->zftsl);
    }


    public function ZM_getOrderStatus_get($cookie,$zftsl)
    {
        $url ="https://cloud.cn2030.com/sc/wx/HandlerSubscribe.ashx?act=GetOrderStatus";
        $client = new Client();
        //设置cookie
        $domain = parse_url($url)['host'];
        $values = [
            'ASP.NET_SessionId' => $cookie,
                'path'=>'/',
        ];
        $cookieJar = CookieJar::fromArray($values, $domain);
        $res = $client->request('post', $url, [
            'cookies' => $cookieJar,
            'headers' => [
                'Host'=> 'cloud.cn2030.com',
                'Connection'=>'keep-alive',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 MicroMessenger/7.0.9.501 NetType/WIFI MiniProgramEnv/Windows WindowsWechat',
                'content-type'=> 'application/json',
                'zftsl'=> $zftsl,
                'Referer'=> 'https://servicewechat.com/wx2c7f0f3c30d99445/91/page-frame.html',
                'Accept-Encoding'=> 'gzip, deflate, br'
            ],

        ]);
        echo $res;
//        echo $res->getBody();
    }


//     public function ZM_Thread(){
//         $url ="https://cloud.cn2030.com/sc/api/User/OrderPost";
//         $client = new Client();
//         //设置cookie
//         $domain = parse_url($url)['host'];
//         $values = [
// //            ['ASP.NET_SessionId'=>'f2daa45xrsqr33qqwcvjqw1m',
// //            'Path'=>'/', 'HttpOnly'=>true,'SameSite'=>'Lax'],
//             'ASP.NET_SessionId' => $this->cookie,
//             'path'=>'/'
//             ];
//         $cookieJar = CookieJar::fromArray($values, $domain);
//         $res = $client->request('post', $url, [
//             'cookies' => $cookieJar,
//             'headers' => [
//                 'Host'=> 'cloud.cn2030.com',
//                 'Connection'=>'keep-alive',
// //                'Content-Length'=> 384,
//                 'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 MicroMessenger/7.0.9.501 NetType/WIFI MiniProgramEnv/Windows WindowsWechat',
//                 'content-type'=> 'application/json',
//                 'zftsl'=>  $this->zftsl,
//                 'Referer'=> 'https://servicewechat.com/wx2c7f0f3c30d99445/91/page-frame.html',
//                 'Accept-Encoding'=> 'gzip, deflate, br'
//             ],
//             'body'=>$this->body,
//         ]);
//         echo $res->getBody();
//     }

public function ZM_Thread($birthday,$tel,$sex,$username,$doctype,$idcard,$mxid,$date,$pid,$Ftime,$cookie,$zftsl){
    $username = urlencode($username);
    $url ="https://cloud.cn2030.com/sc/wx/HandlerSubscribe.ashx?act=Save20&birthday=".$birthday."&tel=".$tel."&sex=".$sex."&cname=".$username."&doctype=".$doctype."&idcard=".$idcard."&mxid=".$mxid."&date=".$date."&pid=".$pid."&Ftime=".$Ftime."&guid=";
    $client = new Client();
    //设置cookie
    $domain = parse_url($url)['host'];
    $values = [
        'ASP.NET_SessionId' => $cookie,
        'path'=>'/'
    ];
    $cookieJar = CookieJar::fromArray($values, $domain);
    $res = $client->request('get', $url, [
        'cookies' => $cookieJar,
        'headers' => [
            'Host'=> 'cloud.cn2030.com',
            'Connection'=>'keep-alive',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 MicroMessenger/7.0.9.501 NetType/WIFI MiniProgramEnv/Windows WindowsWechat',
            'content-type'=> 'application/json',
            'zftsl'=> $zftsl,
            'Referer'=> 'https://servicewechat.com/wx2c7f0f3c30d99445/91/page-frame.html',
            'Accept-Encoding'=> 'gzip, deflate, br'
        ]
    ]);
    echo $res->getBody();
}

    public function post(){

    }

    public function getMxid(){
        $url ="https://cloud.cn2030.com/sc/wx/HandlerSubscribe.ashx?act=GetCustSubscribeDateDetail&pid=1&id=2560&scdate=2022-01-19";
        $client = new Client();
        //设置cookie
        $domain = parse_url($url)['host'];
        $values = [
            'ASP.NET_SessionId' => $this->cookie,
            'path'=>'/'
        ];
        $cookieJar = CookieJar::fromArray($values, $domain);
        $res = $client->request('get', $url, [
            'cookies' => $cookieJar,
            'headers' => [
                'Host'=> 'cloud.cn2030.com',
                'Connection'=>'keep-alive',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 MicroMessenger/7.0.9.501 NetType/WIFI MiniProgramEnv/Windows WindowsWechat',
                'content-type'=> 'application/json',
                'zftsl'=> $this->zftsl,
                'Referer'=> 'https://servicewechat.com/wx2c7f0f3c30d99445/91/page-frame.html',
                'Accept-Encoding'=> 'gzip, deflate, br'
            ]
        ]);
        echo $res->getBody();
    }
    
    public function getMxid1(){
        $url ="https://cloud.cn2030.com/sc/wx/HandlerSubscribe.ashx?act=GetCustSubscribeDateDetail&pid=1&id=2560&scdate=2022-01-19";
        $client = new Client();
        //设置cookie
        $domain = parse_url($url)['host'];
        $values = [
//            ['ASP.NET_SessionId'=>'f2daa45xrsqr33qqwcvjqw1m',
//            'Path'=>'/', 'HttpOnly'=>true,'SameSite'=>'Lax'],
            'ASP.NET_SessionId' => $this->cookie,
            'path'=>'/'
        ];
        $cookieJar = CookieJar::fromArray($values, $domain);
        $res = $client->request('post', $url, [
            'cookies' => $cookieJar,
            'headers' => [
                'Host'=> 'cloud.cn2030.com',
                'Connection'=>'keep-alive',
//                'Content-Length'=> 384,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 MicroMessenger/7.0.9.501 NetType/WIFI MiniProgramEnv/Windows WindowsWechat',
                'content-type'=> 'application/json',
                'zftsl'=>  $this->zftsl,
                'Referer'=> 'https://servicewechat.com/wx2c7f0f3c30d99445/91/page-frame.html',
                'Accept-Encoding'=> 'gzip, deflate, br'
            ],
            'body'=>$this->body,
        ]);
        echo $res->getBody();
    }


}
