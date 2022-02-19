<?php

namespace app\models\definitions;

/**
 * @SWG\Definition(required={"search_query", "string"})
 * @SWG\Property(property="order", type="string",example="stars")
 * @SWG\Property(property="sort", type="string",example="desc")
 *  @SWG\Property(property="search_query", type="string" , example="created:>2022-02-17")
 */
class Repository
{
}