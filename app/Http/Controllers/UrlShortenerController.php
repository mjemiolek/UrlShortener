<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Url;

class UrlShortenerController extends Controller
{
    // Store old and new url in database.

    public function store(Request $request)
    {
        try
        {
            if(auth()->user()->id)
            {
                $longUrl = $request->get('url');
                $newGeneratedUrl = $request->get('shortlink');

                if($longUrl != '' || $newGeneratedUrl != '')
                {
                    $urlFound = Url::where('old_url', $longUrl)->get(['id', 'new_url'])->toArray();

                    if(!empty($urlFound))
                    {
                        return $urlFound[0]['new_url'];
                    }
                    else
                    {
                        $urlTable = new Url;
                        $urlTable->old_url = $longUrl;
                        $urlTable->new_url = $newGeneratedUrl;
                        $urlTable->user_id = auth()->user()->id;
                        $urlTable->user_ip = $_SERVER['REMOTE_ADDR'];
                        $urlTable->save();

                        if($urlTable->save())
                        {
                            return $urlTable->new_url;
                        }
                    }
                }
            }
        }
        catch(Exception $err)
        {
            dd($err);
        }
    }


    // Get URLS
    public function getUserUrls($id)
    {
        $urls = Url::where('user_id', $id)->get();

        if (!$urls) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($urls);
    }



    // Redirect user to original url
    public function handle(Request $request, $url)
    {
        try
        {
            $uri = $_SERVER['REQUEST_URI'];

            if($uri == '')
            {
                return abort(404);
            }

            $url = Url::where('new_url', 'like', '%'.$uri.'%')->get('old_url');

            if($url == '' || count($url) == 0)
            {
                return abort(404);
            }
            else
            {
                return redirect($url[0]['old_url']);
            }

        }
        catch(exception $err)
        {
            dd($err);
        }
    }
}
