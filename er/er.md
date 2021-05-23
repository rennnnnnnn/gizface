```uml
@startuml erdiagram

package "「GizFace」" as application_scheme <<Database>>{
entity "users" {
    　　　　　　　ユーザー
    ==
    + id [PK]
}

entity "social_providers" {
    　　　　　　　　　　　　　ソーシャルプロバイダ
    ==
    + id [PK]
    # user_id[FK(users.id)]
}

entity "profiles" {
    　　　　　　　　　　プロフィール
    ==
    + id [PK]
    # user_id[FK(users.id)]
}

entity "qualifications" {
    　　　　　　　　　資格
    ==
    + id [PK]
    # profile_id[FK(profiles.id)]
   }



entity "careers" {
    　　　　　　　　　職歴
    ==
    + id [PK]
    # profile_id[FK(profiles.id)]
   }



entity "posts" {
    　　　　　　　　　　　投稿
    ==
    + id [PK]
    # profile_id[FK(profiles.id)]
  }

entity "comments" {
    　　　　　　　　　   コメント　　　　
    ==
    + id [PK]
    # post_id[FK(posts.id)]
}



entity "replies" {
    　　　　　　　　　返信
    ==
    + id [PK]
    # comment_id[FK(comments.id)]
   }

entity "career_details" {
    　　　　　　　　　職歴詳細
    ==
    # career_id [FK(careers.id)]
    # profile_id[FK(profiles.id)]
    # skill_master_id[FK(skill_masters.id)]
   }

entity "skill_masters" {
    　　　　　　　　　スキルマスタ
    ==
    + id [PK]
    # category_id[FK(catßßßegory_masters.id)]
   }

entity "category_masters" {
    　　　　　　　　　カテゴリマスタ
    ==
    + id [PK]
   }

users||--|{social_providers
users||--|| profiles
profiles||--|{posts
profiles||--|{careers
profiles||--|{qualifications
careers||--|{career_details
profiles||--|{career_details
skill_masters||--|{career_details
skill_masters||--|{category_masters
posts||--|{comments
comments||--|{replies

}
@enduml
```
