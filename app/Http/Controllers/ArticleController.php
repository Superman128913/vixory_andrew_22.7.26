<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\DeleteArticleRequest;
use App\Http\Requests\Articles\GetArticleDetailsRequest;
use App\Http\Requests\Articles\ListArticleRequest;
use App\Http\Requests\Articles\ArticleListUsersRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Models\Article;

class ArticleController extends Controller
{
    public function single(Request $request, Article $article)
    {
        return response()->json($article, 200);
    }

    public function listUsers(ArticleListUsersRequest $request, User $user)
    {
        $request->validated();
        return response()->json($user->articles, 200);
    }

    public function list(ListArticleRequest $request)
    {
        $user = \Auth::user();
        $articles = $user->articles;

        return response()->json($articles, 200);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $fields = $request->validated();

        //Strip out the featured image url
        if(array_key_exists("featured_image", $fields))
        {
            $url = $fields["featured_image"];
            unset($fields["featured_image"]);
        }

        //Update the article
        $article->update($fields);

        //Upload the articles featured image
        if($url){
            $article->addMediaFromUrl($url)->toMediaCollection("featured-image");
        }
                
        return response()->json($article, 200);
    }

    public function store(CreateArticleRequest $request)
    {
        $fields = $request->validated();

        //Add the current users id to the request
        $user = \Auth::user();
        $fields["user_id"] = $user->id;

        //Strip out the featured image url
        if(array_key_exists("featured_image", $fields))
        {
            $url = $fields["featured_image"];
            unset($fields["featured_image"]);
        }

        //Create the new article
        $article = Article::create($fields);
        
        //Upload the articles featured image
        if($url){
            if(! app()->isLocal())
            {
                //Standard image upload from url.
                $article->addMediaFromUrl($url)->toMediaCollection("featured-image");
            }
            else 
            {
                //Convoluted way of uploading an image from a url when using laravel valet locally.
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $image_contents = base64_encode(file_get_contents($url, false, stream_context_create($arrContextOptions)));
                $article->addMediaFromBase64($image_contents)->toMediaCollection("featured-image");
            }            
        }

        return response()->json($article);
    }

    public function delete(DeleteArticleRequest $request, Article $article)
    {
        $article->delete();
        return response()->json("Article Deleted", 200);
    }

    public function getDetails(GetArticleDetailsRequest $request)
    {
        $fields = $request->validated();
        $url = $fields["url"];
        $page = new \stdClass();

        //First check that the url is good.
        $response = Http::get($url);
        if($response->successful())
        {
            $body = $response->body();

            //Get the meta description/title.
            $crawler = new Crawler($body);

            $h1 = $crawler->filterXpath('//h1');
            if($h1->count() > 0) 
            {
                $page->title = $h1->text();
            }

            $description = $crawler->filterXpath('//meta[@name="description"]');
            if($description->count() > 0) 
            {
                $page->description = $description->attr('content');
            }

            //Take a screenshot of the site and save it to a temp file.
            $file_name = (string) Str::uuid() . '.png';
            $temp_path = storage_path() . '/app/public/tmp/' . $file_name;

            //If setup locally get the node and npm path from env
            if (\App::environment(['local'])) 
            {
                $node_binary = env('NODE_BINARY', null);
                $npm_binary = env('NPM_BINARY', null);
                Browsershot::url($url)
                    ->setNodeBinary($node_binary)
                    ->setNpmBinary($npm_binary)
                    ->addChromiumArguments([
                        'no-sandbox',
                    ])
                    ->waitUntilNetworkIdle()
                    ->save($temp_path);
            }
            else {
                Browsershot::url($url)
                ->setNodeBinary(env('NODE_BINARY', null))
                ->setNpmBinary(env('NPM_BINARY', null))
                ->waitUntilNetworkIdle()
                ->save($temp_path);
            }

            //Get the url of the file we just saved, and add it to the response.
            $page->screenshot = url('/') . Storage::url('tmp/' . $file_name);

            return response()->json($page, 200);
        }
        else 
        {
            return response()->json("Url returned an error.", 400);
        }
    }
}
