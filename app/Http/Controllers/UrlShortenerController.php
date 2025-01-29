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
}
