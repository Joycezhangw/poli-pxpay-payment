<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        if($request->param('name')=='result'){
            return json();//redirect('index/paxpay/print_result');
        }
    }
}
