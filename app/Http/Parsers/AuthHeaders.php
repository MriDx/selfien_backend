<?php
/**
 * Created by PhpStorm.
 * User: ujjwal
 * Date: 12/4/17
 * Time: 2:58 PM
 */

namespace App\Http\Parsers;

use Illuminate\Http\Request;

class AuthHeaders
{
    /**
     * The header name.
     *
     * @var string
     */
    protected $header = 'authorization';
    /**
     * The header prefix.
     *
     * @var string
     */
    protected $prefix = 'bearer';

    /**
     * Attempt to parse the token from some other possible headers.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return null|string
     */
    protected function fromAltHeaders(Request $request)
    {
        return $request->server->get('HTTP_AUTHORIZATION') ?: $request->server->get('REDIRECT_HTTP_AUTHORIZATION');
    }

    /**
     * Try to parse the token from the request header.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return null|string
     */
    public function parse(Request $request)
    {
        $header = $request->headers->get($this->header) ?: $this->fromAltHeaders($request);
        if ($header && preg_match('/' . $this->prefix . '\s*(\S+)\b/i', $header, $matches)) {
            return $matches[1];
        }
    }
}