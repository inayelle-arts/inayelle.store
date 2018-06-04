<?php

namespace app\model\entity;

use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;


/**
 * Class ProductEntity
 * @package app\model\entity
 * @property string        $name
 * @property string        $description
 * @property int           $cost
 * @property int           $type_id
 * @property int           $in_stock
 * @property int           $discount
 * @property int           $size_id
 * @property int           $brand_id
 * @property BrandEntity   $brand
 * @property string        $color
 * @property ImageEntity[] $images
 */
class ProductEntity extends EntityBase
{
	use GetSet;
	
	public const TABLE = "products";
	
	public const FIELDS =
		[
			"name",
			"description",
			"cost",
			"type_id",
			"in_stock",
			"discount",
			"size_id",
			"brand_id",
			"color"
		];
	
	/** @var string $name */
	protected $name;
	
	/** @var string $description */
	protected $description;
	
	/** @var int $cost
	 * IN CENTES
	 */
	protected $cost;
	
	/** @var int $type_id */
	protected $type_id;
	
	/** @var int $in_stock */
	protected $in_stock;
	
	/** @var int $discount
	 * IN PERCENTS
	 */
	protected $discount;
	
	/** @var int $size_id */
	protected $size_id;
	
	/** @var int $brand_id */
	protected $brand_id;
	
	/** @var BrandEntity $brand */
	private $brand;
	
	/** @var string $color */
	protected $color;
	
	/** @var ImageEntity[] $images */
	private $images;
	
	public function __construct() { }
	
	public function getPrimaryImagePath() : string
	{
		if( count( $this->images ) === 0 )
			return "/default_product.jpg";
		
		foreach( $this->images as $image )
			if( $image->primary_image === true )
				return $image->path;
		
		return $this->images[0]->path;
	}
	
	/**
	 * @param array $data
	 *
	 * @return EntityBase
	 * @throws \vendor\core\database\exception\DatabaseCommonException
	 */
	protected static function parseOne( array $data ) : EntityBase
	{
		/** @var ProductEntity $result */
		$result = parent::parseOne( $data );
		
		$brandID       = $result->brand_id;
		$brand         = BrandEntity::getById( $brandID );
		$result->brand = $brand;
		
		$images         = ImageEntity::getByField( "product_id", $result->id );
		$result->images = $images;
		
		return $result;
	}
}