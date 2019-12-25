<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Xml\Service as FeedService;
use HeadlessChromium\BrowserFactory;
use App\Services\Curl;

class ModelYearParserPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     * @var string
     */
    protected $params;

    /**
     * Create a new job instance.
     *
     * @param array $params
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileOk = public_path() . "/parser-ok/" . $this->params['model_year_id'] . ".html";
        if (is_file($fileOk)) {
            return;
        }
        
        $yearContent = Curl::getPage($this->params['url']);
        preg_match( "/sRwd\=\'\/data\/js\/(.*?)\/'/", $yearContent, $matchCode);
        if (!isset($matchCode[1])) {
            return;
        }
        $code = Curl::getPage('https://www.wheel-size.com/data/js/' . $matchCode[1] . '/');
        $html = \phpQuery::newDocument(Curl::getPage($this->params['url']));
        $body = $html->find('#vehicle-market-data')->html();
        $file = "/parser/". $this->params['model_year_id'] .".html";
        file_put_contents(public_path() . $file, (string)view('parser.year', compact('code', 'body')));

        $browserFactory = new BrowserFactory();
        $browser = $browserFactory->createBrowser();
        $page = $browser->createPage();
        $page->navigate('http://uk.autotk.loc' . $file)->waitForNavigation(\HeadlessChromium\Page::LOAD);
        $evaluation = $page->evaluate('document.documentElement.innerHTML');
        $content = self::clean($evaluation->getReturnValue());
        $html = \phpQuery::newDocument('<html>' . $content . '</html>');

        $content = str_replace(['â€“', 'Â'], '', $html->html());
        file_put_contents($fileOk, $content);
    }
  
    public static function clean($str)
    {
        $str = trim($str);
        return str_replace(["\n", "\t", "\r"], '', $str);
    }
    
}
