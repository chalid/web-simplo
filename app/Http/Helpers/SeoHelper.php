<?php

namespace App\Http\Helpers;

use SEOMeta;
use OpenGraph;
use Twitter;
use Illuminate\Support\Facades\URL;

class SeoHelper
{
    public static function setMeta($data)
    {
        // SEOMeta::setTitle($data['meta_title'] ?? config('app.name'));
        // SEOMeta::setDescription($data['meta_description'] ?? '');
        // SEOMeta::addKeyword(explode(',', $data['meta_keywords'] ?? ''));
        // SEOMeta::setCanonical(url()->current());

        // // SEO Meta
        // SEOMeta::setTitle($data['meta_title'] ?? config('app.name'));
        // SEOMeta::setDescription($data['meta_description'] ?? '');
        // SEOMeta::addKeyword(explode(',', $data['meta_keywords'] ?? ''));

        // SEOMeta::addMeta('author', $data['meta_author'] ?? '');
        // // SEOMeta::setCanonical($data['meta_canonical'] ?? url()->current());
        // SEOMeta::addMeta('robots', $data['meta_robots'] ?? 'index, follow');

        // // OpenGraph
        // OpenGraph::setTitle($data['meta_title'] ?? config('app.name'));
        // OpenGraph::setDescription($data['meta_description'] ?? '');
        // OpenGraph::setType('website');
        // OpenGraph::setUrl(url()->current());

        // if (!empty($data['meta_image'])) {
        //     OpenGraph::addImage(asset($data['meta_image']));
        // }

        // // Twitter
        // Twitter::setTitle($data['meta_title'] ?? config('app.name'));
        // Twitter::setDescription($data['meta_description'] ?? '');
        // if (!empty($data['meta_image'])) {
        //     Twitter::setImage(asset($data['meta_image']));
        // }

        //new
        $title          = $data['meta_title'] ?? config('app.name');
        $description    = $data['meta_description'] ?? '';
        $url            = url()->current();
        $path           = 'storage/upload_files/images/';
        $dir            = $data['meta_image_path'] . '/';
        $image          = !empty($data['meta_image']) ? url($path . $dir . 'meta/' . $data['meta_image']) : url('assets/backend/images/png/no_image.png');

        // SEOMeta
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword(explode(',', $data['meta_keywords'] ?? ''));
        SEOMeta::setCanonical($url);
        if (!empty($data['meta_author'])) {
            SEOMeta::addMeta('author', $data['meta_author']);
        }
        if (!empty($data['meta_robots'])) {
            SEOMeta::addMeta('robots', $data['meta_robots']);
        }

        // OpenGraph
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($url);
        OpenGraph::addImage($image);
        OpenGraph::setType('website'); // This fixes og:type

        // Twitter
        Twitter::setTitle($title);
        Twitter::setDescription($description);
        Twitter::setImage($image);
    }
}