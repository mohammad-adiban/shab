<?php

namespace App\Http\Controllers;

use App\Newsletter;

use Illuminate\Http\Request;

use DB;
use SEO;
use Mail;
use Log;
use Config;
use Auth;

use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendEmailNotification;
use App\Jobs\SendSMSNotification;
use App\Jobs\SetServiceDeskStatus;

use App\House;
use App\User;
use App;
use URL;
use App\Text;
use App\Reservation;

class HomeController extends Controller
{

    /**
     * get blog posts
     *
     * @return \Illuminate\Http\Response
     */
    public function getBlogPosts()
    {
        $posts = DB::connection('blog')->table('blog_posts')->select('id', 'post_title', 'meta_value')->where('post_status' , 'publish')->leftJoin('blog_postmeta', 'blog_posts.id', '=', 'blog_postmeta.post_id')->where('blog_postmeta.meta_key', '_thumbnail_id')->orderBy('id', 'dec')->take(10);

        $posts_thumbnails = DB::connection('blog')->table('blog_posts')->select('id', 'guid')->whereIn('id', $posts->pluck('meta_value'))->get();

        return array('posts' => $posts->get(), 'posts_thumbnails' => $posts_thumbnails);
    }

    /**
     * Dynamic sitemap generator
     *
     * @return xml
     */
    public function generateSitemap()
    {
        $sitemap = App::make("sitemap");

        $sitemap->setCache('laravel.sitemap', 360);

        if (!$sitemap->isCached())
        {
            //general pages
            $sitemap->add(URL::to('/')         , date('Y-M-d'), '1.0', 'daily');
            $sitemap->add(URL::to('blog')      , date('Y-M-d'), '1.0', 'daily');
            $sitemap->add(URL::to('about')     , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('terms')     , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('refund')    , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('careers')   , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('policies')  , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('help/host') , date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('help/guest'), date('Y-M-d'), '1.0', 'weekly');
            $sitemap->add(URL::to('complaints'), date('Y-M-d'), '1.0', 'weekly');

            //search cities
            $cities = House::distinct()->select('province', 'city')->bookable()->orderBy('city', 'asc')->get();
            foreach ($cities as $city)
            {
                //$sitemap->add(URL::to('search?destination='.$city['city']), date('Y-M-d'), '0.9', 'daily');
                $sitemap->add(URL::to('search/province/'.$city['province']), date('Y-M-d'), '0.9', 'daily');
                $sitemap->add(URL::to('search/city/'.$city['city']), date('Y-M-d'), '0.9', 'daily');
                $sitemap->add(URL::to('search/province/'.$city['province'].'/city/'.$city['city']), date('Y-M-d'), '0.9', 'daily');
            }
            
            //blog posts
            $posts = DB::connection('blog')->table('blog_posts')->where('post_status', 'publish')->get(['post_date', 'post_name', 'post_modified']);
            foreach ($posts as $post)
            {
                $post_date = date_create($post->post_date);
                //$sitemap->add(URL::to('blog/'.date_format($post_date, 'Y').'/'.date_format($post_date, 'm').'/'.$post->post_name), $post->post_modified, '0.9', 'monthly');
                $sitemap->add(URL::to('blog/'.$post->post_name), $post->post_modified, '0.9', 'monthly');
            }

            //houses
            $houses = House::bookable()->orderBy('created_at', 'desc')->get();
            foreach ($houses as $house)
            {
                $images = [
                    ['url' => URL::to($house->photos->first()['path']), 'title' => 'اجاره ویلا در شهر '.$house->city.' استان '.$house->province, 'geo_location' => $house->city. ', '.$house->province],
                ];
                $sitemap->add(URL::to('houses/show/'.$house->id), $house->updated_at, '1.0', 'daily', $images);
            }

            //tags
            $tags = House::existingTags();
            foreach ($tags as $tag) {
                $sitemap->add(URL::to('search/tag/'.$tag['name']), date('Y-M-d'), '0.9', 'daily');
            }
        }

        return $sitemap->render('xml');
    } 

    /**
     * Create a new controller instance.
     *
     * @return void
     
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the statistics page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStatistics()
    {
        $user = Auth::user();
        if(in_array($user->id, [1, 2, 4, 649]))
            return view('stats');
        else
            redirect("/");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLandingPage()
    {
        SEO::setTitle('شب | اجاره ویلا، اجاره ویلا در شمال، اجاره سوئیت، کرایه ویلا');
        SEO::setDescription('سایت شب | اجاره ویلا، اجاره ویلا در شمال ایران، اجاره سوئیت، اجاره ویلای استخردار، اجاره ویلای ساحلی، اجاره ویلای جنگلی، اجاره ویلا در کیش، اجاره ویلا در اطرف تهران، اجاره ویلا در شیراز، اجاره ویلا در کیش، اجاره ویلا در محمود آباد، اجاره ویلا در چالوس، اجاره روزانه ویلا در شمال ایران، اجاره ویلا با بهترین قیمت');

        SEO::opengraph()->setTitle('شب | اجاره روزانه ویلا در شمال و سراسر کشور');
        SEO::opengraph()->setType('website');
        SEO::opengraph()->setUrl('https://www.shab.ir');
        SEO::opengraph()->addImage('https://www.shab.ir/img/logo.png');
        SEO::opengraph()->setDescription('سایت اجاره ویلا در شمال، کیش، مشهد، کلاردشت، نمک آبرود، چالوس و سایر نقاط کشور. اجاره ویلاهای ساحلی، جنگلی، روستایی و استخردار.');
        SEO::opengraph()->addProperty('locale', 'fa_IR');

        return view('welcome');
    }

    public function showPolicies()
    {
        SEO::setTitle('قوانین استفاده از شب');

        $page = DB::table('company')->where('section', 'policies')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showCareers()
    {
        SEO::setTitle('همکاری با شب');

        return view('company');
    }

    public function submitCareerForm(Request $request)
    {
        #TODO: Validate inputs

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.career', ['name' => $request->name, 'mobile' => $request->mobile, 'email' => $request->email, 'career_type' => $request->career_type, 'details' => $request->details], 'درخواست همکاری #career'));

        #Email
        $this->dispatch(new SendEmailNotification('emails.career', ['name' => $request->name, 'mobile' => $request->mobile, 'email' => $request->email, 'career_type' => $request->career_type, 'details' => $request->details], 'درخواست همکاری', ['info@shab.ir']));
        /*
        Mail::send('emails.career', ['request' => $request], function ($message) {
            $message->subject('درخواست همکاری');
            $message->from('automated@shab.ir', 'Shab.ir');
            $message->to(['info@shab.ir']);
        });
        */

        return redirect()->route('careers')->with('status', 'درخواست شما با موفقیت ثبت گردید.');
    }

    public function showAbout()
    {
        SEO::setTitle('درباره شب');

        $page = DB::table('company')->where('section', 'about')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showTerms()
    {
        SEO::setTitle('حقوق کاربران در شب');

        $page = DB::table('company')->where('section', 'terms')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showRefund()
    {
        SEO::setTitle('قواعد شب درباره بازپرداخت وجوه');

        $page = DB::table('company')->where('section', 'refund')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showHelpHost()
    {
        SEO::setTitle('چگونه میزبان شوم؟');

        $page = DB::table('company')->where('section', 'helphost')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showHelpGuest()
    {
        SEO::setTitle('چگونه میهمان شوم؟');

        $page = DB::table('company')->where('section', 'helpguest')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showHelpTrust()
    {
        SEO::setTitle('چگونه اعتماد کنم؟');

        $page = DB::table('company')->where('section', 'helptrust')->first();
        return view('company', ['content' => $page->content]);
    }

    public function showComplaints()
    {
        SEO::setTitle('ثبت شکایات');

        $page = DB::table('company')->where('section', 'complaints')->first();
        return view('company', ['content' => $page->content]);
    }

    /**
     * Show intersting roads page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGuideRoads()
    {
        SEO::setTitle('مسیرهای تفریحی جذاب');

        return view('guide');
    }

    /**
     * Show village houses page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGuideVillage()
    {
        SEO::setTitle('اقامتگاه های روستایی');

        return view('guide');
    }

    /**
     * Show seasonal houses page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGuideSeasonal()
    {
        SEO::setTitle('اقامتگاه های فصلی');

        return view('guide');
    }

    /**
     * Show historical places page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGuideHistorical()
    {
        SEO::setTitle('اقامتگاه های تاریخی');

        return view('guide');
    }

    /**
     * Subscribe to newsletter
     *
     * @return void
     */
    public function subscribeNewsletter(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:newsletters|max:255',
        ]);
        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();
        return view('welcome');
    }

    public function home_tmp() {
        return view('home_tmp');
    }

    /**
     * Received SMS handler
     *
     * @return void
     */
    public function smsHandler(Request $request)
    {
        $this->validate($request, [
            'message'   => 'required|string|max:255',
            'messageid' => 'required|numeric',
            'from'      => 'required|numeric',
            'to'        => 'required|numeric',
        ]);

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.sms', ['text' => $request->message, 'messageid' => $request->messageid, 'from' => $request->from, 'to' => $request->to], 'دریافت پیامک #sms'));

        $host        = User::where('mobile', $request['from'])->first();
        if(is_null($host))
            return;

        #Finding the related reservation
        $texts_count = Text::where('from', $request['from'])->whereIn('message', ['1', '2', '3'])->where('created_at', '>', date('Y-m-d H:i:s',time()-21600))->count();
        $reservation = Reservation::where('host_user_id', $host->id)->orderBy('created_at', 'asc')->where('created_at', '>', date('Y-m-d H:i:s',time()-21600))->skip($texts_count)->first(); //6 hours validation
        if(is_null($reservation) || $reservation->status != 0)
            return;
        
        $guest = $reservation->guest;

        switch ($request['message']) {
            case '1':
                $reservation->status = 1;
                $reservation->save();

                #Sending sms for host
                $this->dispatch(new SendSMSNotification(getHostAcceptReservationSms(), array($reservation->host->mobile)));
                #Sending sms for guest
                $this->dispatch(new SendSMSNotification(getGuestAcceptReservationSms($reservation), array($guest->mobile)));
                #Set Service Desk Status
                $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_ACCEPT') );

                break;
            case '2':
                setUnavailable($reservation);
                $reservation->status = 2;
                $reservation->save();

                #Sending sms to host
                $this->dispatch(new SendSMSNotification(getHostUnavailableSms(), array($reservation->host->mobile)));
                #Sending sms to guest
                $this->dispatch(new SendSMSNotification(getGuestUnavailableSms($reservation), array($guest->mobile)));
                #Set Service Desk Status
                $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_REJECT') );

                break;
            case '3':
                #Set Service Desk Status
                $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_NEW_PRICE') );
                #Sending sms to host
                $this->dispatch(new SendSMSNotification(getHostRejectReservationSms($reservation), array($host->mobile)));
                #Sending sms to guest
                $this->dispatch(new SendSMSNotification(getGuestUnavailableSms($reservation), array($guest->mobile)));

                break;
            default:
                return;
                //break;
        }
        
        #Saving the received SMS
        $this->storeSMS($request['messageid'], $request['message'], $request['from'], $request['to']);
    }

    /**
     * Store SMS
     *
     * @return void
     */
    public function storeSMS($messageid, $message, $from, $to)
    {
        $text = new Text;
        $text->message   = $message;
        $text->messageid = $messageid;
        $text->from      = $from;
        $text->to        = $to;
        $text->save();
    }
}

