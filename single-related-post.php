<?php
/*
Plugin Name: Single Related Post
Plugin URI: 
Description: show link in style
Version: 1.0.0
Author:Yutaro Ohno
Author URI: 
License: GPL2
 */

/*  Copyright 2018 Yutaro Ohno (email : プラグイン作者のメールアドレス)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function create_related_field($atts) {
  if (!isset($atts["id"])) {
    return false;
  }
  
  $id = $atts["id"];
  $post =get_post( $id );
  if(!$post ) return false;
 
  $link     = get_permalink($post->ID);
  $img_src  = get_the_post_thumbnail( $post->ID,array(80,80));
  $contents = mb_strimwidth($post->post_content, 0, 70, "...","UTF-8");
 
  $str =<<<EOS
    <div class="postLink">
      <a href="{$link}">
        {$img_src}
        <div class="content">
          <h4 class="title">{$post->post_title}</h4>
          <p>{$contents}</p><div></div>
        </div>
      </a>
    </div>
EOS;
  return $str;
}

add_shortcode('post', 'create_related_field');

add_action('wp_head','post_css');
 
function post_css($headers){
        echo <<<EOS
        <style type="text/css">
          .postLink{
            border:1px solid #ccc;
            padding:2pt;margin:5pt;
            max-height: 160px;
            border-radius: 10px;
          }

          .postLink::after {
            content: '';
            clear: both;
            display: block;
          }
          
          .content {
            float: left;
            margin: 10px 10px 10px 20px;
          }  
          .postLink img{
            margin: 20px;
            float: left;
           }

          .title::before {
            content: '関連記事';
            background-color: #2E9AFE;
            color: #fff;
            font-size: 12px;
            padding: 7px;
            border-radius: 5px;
            position: relative;
            bottom: 2px;
          }

          .title {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
          }


          @media screen and (min-width: 320px) {
            .content {
              width: 150px;
              margin-top: -15px;
            }

            .content p {
              display: -webkit-box;
              -webkit-box-orient: vertical;
              -webkit-line-clamp: 2;
              overflow: hidden;
            }
          }

          @media screen and (min-width:480px) {
            .content {
              width: 350px;
              margin-top: -15px;
            }
          }

          @media screen and (min-width:768px) {
            .content {
              width: 500px;
              margin-top: -15px;
            }
          }
  
          @media screen and (min-width:1024px) {
            .content {
              width: 500px;
              margin-top: -15px;
            }
          }

       </style>
EOS;
}

?>
