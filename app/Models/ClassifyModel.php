<?php

namespace App\Models;


class ClassifyModel
{
    const table = 't_classify';

    /*增*/

    static $AddArticleClassifyInsert = [
        'SQL'=> 'insert into  '.self::table.' (classify_id,classifyname) values (:classify_id,:classifyname)'
    ];

    /*查*/
    static $SelectArticleClassifySelect = [
        'SQL'=> 'select * from '.self::table
    ];




}