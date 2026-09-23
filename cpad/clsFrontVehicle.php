<?php

class FrontVehicle {
    public $make;
    public $model;
    public $title;
    public $price;
    public $mainImage;
    public $url;
    public $thumb;
    public $images;
    public $year;
    public $mileage;
    public $fuel;
    public $transmission;
    public $body;
    public $color;
    public $cc;
    public $options;
    public $description;

    public function __construct($vehicle) {
        $server = CommonBase::getServer();

        // Every text field below is escaped once here, at construction, so
        // every page that displays a FrontVehicle (vehicle detail, listings,
        // homepage product cards) automatically gets safe output without each
        // of them needing to remember to call htmlspecialchars() themselves.
        // modeltxt/description are free text entered via the admin vehicle
        // form; make/model/fuel/transmission/body/color/cc are admin-managed
        // lookup-table names - all are still escaped for defense in depth.
        $this->make = htmlspecialchars(Vehicle::getname($vehicle['fk_make'], "make") ?? '', ENT_QUOTES, 'UTF-8');
        $this->model = htmlspecialchars(Vehicle::getname($vehicle['fk_model'], "model") ?? '', ENT_QUOTES, 'UTF-8');
        $this->title = trim($this->make . ' ' . $this->model . ' - ' . htmlspecialchars($vehicle['modeltxt'] ?? '', ENT_QUOTES, 'UTF-8'));
        $this->price = Vehicle::getPrprice($vehicle);
        $firstImage = Vehicle::getFirastimage($vehicle['Id']);
        $this->mainImage = $server . $firstImage['tpath'] . $firstImage['image_name'];
        $this->url = Vehicle::createUrl($vehicle);
        $this->thumb = $server . $firstImage['tpath'] . $firstImage['image_name'];
        $this->images = $this->getImages($vehicle);
        //var_dump($this->images);die;
        $this->year = htmlspecialchars($vehicle['yearmonth'] ?? '', ENT_QUOTES, 'UTF-8');
        $mileage = $vehicle['mileage'];
        $mileageUnit = is_numeric($vehicle['fk_mileage']) ? CommonBase::getname($vehicle['fk_mileage'], "mileage") : " KM";
        $this->mileage = htmlspecialchars($mileage . $mileageUnit, ENT_QUOTES, 'UTF-8');
        $this->fuel = htmlspecialchars(CommonBase::getname($vehicle['fk_fuel'], "fuel") ?? '', ENT_QUOTES, 'UTF-8');
        $this->transmission = htmlspecialchars(CommonBase::getname($vehicle['fk_transmission'], "transmission") ?? '', ENT_QUOTES, 'UTF-8');
        $this->body = htmlspecialchars(CommonBase::getname($vehicle['fk_body_type'], "body_type") ?? '', ENT_QUOTES, 'UTF-8');
        $this->color = htmlspecialchars(CommonBase::getname($vehicle['fk_color'], "colour") ?? '', ENT_QUOTES, 'UTF-8');

        $this->cc = htmlspecialchars(CommonBase::getname($vehicle['fk_engine_capacity'], 'engine_capacity') ?? '', ENT_QUOTES, 'UTF-8');
       // var_dump($vehicle,$vehicle['fk_engine_capacity']);die;
        $this->options = $this->getOptions($vehicle);
        $this->description = htmlspecialchars($vehicle['description'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    public function getImages($vehicle){
        $allImages  = Vehicle::getAllimages($vehicle['Id']);

        $server = CommonBase::getServer();
        $arr = [];
        foreach ($allImages as $image) {
            $arr[] = [
                'thumb' => $server . $image['tpath'] . $image['image_name'],
                'main' => $server . $image['mpath'] . $image['image_name']
            ];
        }
        return $arr;
    }

    public function getLimitTitle($limit = 25) {
        $title = $this->title;
        if (strlen($title) > $limit) {
            $title = substr($title, 0, $limit) . '...';
        }
        return $title;
    }

   public function getYearOnly(){
        $year = $this->year;
        if (strlen($year) > 4) {
            $year = substr($year, 0, 4);
        }
        return $year;
    }


    private function getOptions($vehicle) {
        $optionArr = [
            'rearwiper' => 'Rear Wiper',
            'ac' => 'AC',
            'pm' => 'Power Mirror',
            'tv' => 'TV',
            'ps' => 'Power Steering',
            'abs' => 'ABS',
            'pw' => 'Power Window',
            'dvd' => 'DVD',
            'aw' => 'Alloy Wheels',
            'r_camera' => 'Reverse Camera',
            'winkermirror' => 'Winker Mirror',
            'skey' => 'Smart Key',
            'foglamp' => 'Foglamp',
            'leather' => 'Leather Seats'
        ];

        $arrCurrent = [];
        foreach ($optionArr as $key => $value) {
            if ($vehicle[$key] == 1) {
                $arrCurrent[$key] = $value;
            }
        }

        return $arrCurrent;
    }
}

?>
