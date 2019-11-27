<?php

namespace App\Http\Middleware;

use Closure;

class WebhookVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('APP_ENV') === 'staging' || env('APP_ENV') === 'local')
            return $next($request);

	    if ($header_hmac = $request->server('HTTP_X_SHOPIFY_HMAC_SHA256'))
	    {
		    $data     = file_get_contents( 'php://input' );
		    $verified = $this->verifyWebhook( $data, $header_hmac );
		    if($verified) {
			    return $next($request);
		    } 
	    } 
    }
	
	private function verifyWebhook( $data, $hmac_header )
	{
		$calculated_hmac = base64_encode( hash_hmac( 'sha256', $data, env( 'SHOPIFY_SECRET_KEY' ), true ) );
		return ( $hmac_header == $calculated_hmac );
	}
}


