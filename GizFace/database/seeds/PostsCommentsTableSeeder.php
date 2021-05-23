<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostCategory;

class PostsCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = 'この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。';

        $commentdammy = 'コメントダミーです。';

        // カテゴリーを追加する
        $postCategory1 = new PostCategory;
        $postCategory1->category = "プログラミング";
        $postCategory1->save();

        $postCategory2 = new PostCategory;
        $postCategory2->category = "バックエンド";
        $postCategory2->save();

        $postCategory3 = new PostCategory;
        $postCategory3->category = "フロントエンド";
        $postCategory3->save();

        $postCategory4 = new PostCategory;
        $postCategory4->category = "PHP";
        $postCategory4->save();

        $postCategory5 = new PostCategory;
        $postCategory5->category = "その他";
        $postCategory5->save();

        $postCategory6 = new PostCategory;
        $postCategory6->category = "趣味";
        $postCategory6->save();

        $postCategory7 = new PostCategory;
        $postCategory7->category = "コード";
        $postCategory7->save();

        $postCategory8 = new PostCategory;
        $postCategory8->category = "ツール";
        $postCategory8->save();

        $postCategory9 = new PostCategory;
        $postCategory9->category = "雑談";
        $postCategory9->save();

        $postCategory11 = new PostCategory;
        $postCategory11->category = "本";
        $postCategory11->save();

        for ($i = 1; $i <= 10; $i++) {
            $post = new Post;
            $post->profile_id = 1;
            $post->title = "$i 番目の投稿";
            $post->body = $content;
            $post->post_category_id = 1;
            $post->image_path = 'https://www.jungleocean.com/demo/jquery-slick/images/1.jpg';
            $post->created_user = '藤江 廉';
            $post->save();

            $comment = new Comment;
            $comment->post_id = $i;
            $comment->body = $commentdammy;
            $comment->created_profile_id = $i;
            $comment->created_user = '名無し';
            $comment->save();
        }
    }
}
