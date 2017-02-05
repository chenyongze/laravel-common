<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail as Mailer;

class QueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailInfo)
    {
        //
        $this->emailInfo=$emailInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $name = '育儿百科';
        $to = $this->emailInfo;
//        $to = 'sapphire.php@gmail.com';
//        http://i1.piimg.com/567571/f41c7badc37edd15.jpg
        $imgPath = 'Vm0weE5GVXhTWGhYV0doV1YwZG9WRmx0Y3pGalJsSlZVMnhPYWxKc1ducFdNblF3Vm1zeFYyTklhRlpOYm1oUVZtdFZlRll4WkhOWGJGcFhUVEZLZVZadGVHRlRNazV5VGxaa1lWSnRVbFJVVkVGNFRrWmFkR1JHV214U2F6VkpWbTEwWVZZeVNraFZiRkphWWtad1RGcFZXbXRqYkd0NllVWk9hVlpzY0ZsV2JHTXhWakZrU0ZOc2JGWmlWR3hoVm10V2NrMUdjRVZTYlhSWFRWZFNlbFl5Y3pWV01ERkZWbXBhVjJFeVRYaFdWRXBIVWpGT1dXTkdTbWhsYlhob1YxWlNSMlF4WkVkVmJrNVlZbFZhVlZWcVJrdFNNV1J5VmxSV2FGSXhXbnBWTVZKTFZqRmFObEpZWkZabGExcFhXbFZhVDJSV1RuUmpSazVYVmtaYVdsWXhaREJoTVZWNVZXNU9XR0pzU25OVmFrSmhWa1pTVjFkdVpHeFNiSEJKV1ROd1IxWXdNVmRqUm1oYVRVWndTRlpxUmxwbGJVWkhZVVphYkdFd1ZqUldWM0JIV1ZkTmVWSnJaR0ZTTW1oUFZqQldTMWRXV1hoWGJFNVVUVlpXTkZaSGRHdFdiVXBIWTBac1dtSllUWGhXTUZwVFZqRmtkVnBIZUdsU2JrSktWMnhXWVZReFpITlhiazVxVTBoQ1lWbFVSa3RoUmxwMFpVZEdVMkpWTlVwWk1GcGhWakpXY2xkcmJGaFdSV3cwVlhwR1MyTXhXblZVYkVwcFVsUldXVlpxUWxkVE1WSlhWMjVPV2sweWFFOVZiWE40VGtaYWRHUkhkRmROYTNCNlZqSXhiMVp0U2toVmJGSlhZa1p3V0ZwRlpFOU9iRXB6V2tVMVYySllZM2RXYlRCNFRVVXhSMWRZYUZSWFIxSnhWV3hrVTFZeFVsaE9WazVzWWtad1dWcFZaRWRoYXpGWVZXNXNZVlpXY0hKV1ZFRjNaVmRHUjJKR1pGZGlWa1YzVmxod1MxUnRWa2RhU0ZaVllrWndjRlZxUmt0WFZtUllaVWM1YVUxVmNGaFdNalZUWWtaS2RGVnRSbGRpV0doSVZHdGFWbVZYVmtoU2JGcE9ZVE5DU1ZkVVFtOVJNVnAwVTJ0a2FsSllhRmhaYkdodlRURmFjVkp0Um1waVZrcElWbGR6TVZZeVNrbFJhMnhYWWtkUk1GWlVSbFpsUm1SeVYyczFWMVl5YUhwV1YzaGhXVlprUjFadVVteFNia0p5VkZaYVYwNVdjRlpXYlVab1RVUkdWMWt3VWtOV1YwcEhZMFpTVjJGcldtaFdiRnBoWTJ4V2MxcEZOV2xoTUhCR1ZqRm9kMUl4VFhoVFdHaFVZbXMxV0ZsWWNGZFdSbFp5Vm10YVQxVlVNRGs9';
//        $imgPath = ' http://i1.piimg.com/567571/f41c7badc37edd15.jpg';
        try{
            $flag = Mailer::send('emails.baby',['name'=>$name,'imgPath'=>$imgPath],function($message) use($to) {
                $message ->to($to)->subject('育儿百科[您身边的朋友]');
            });
        }catch (\App\Exceptions\Handler $e){
            print_r($e);
        }
        return '';
    }
}
