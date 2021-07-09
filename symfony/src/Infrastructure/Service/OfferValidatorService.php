<?php


namespace App\Infrastructure\Service;


use App\Domain\Service\OfferValidatorServiceInterface;

class OfferValidatorService implements OfferValidatorServiceInterface
{
    public const AVERAGE = 25;

    /**
     * Search offers that are above average
     *
     * @return array
     */
    public function validateOffers(): array
    {
        // Parse CSV and JSON files
        $offersCSV = $this->parseCSV("public/feed.csv");

        // Convert JSON string to Array
        $offersJSONString = file_get_contents("public/feed.json");
        // Fix JSON - Remove last comma
        $offersJSONString = substr($offersJSONString, 0, -3) . ']';
        $offersJSON = json_decode($offersJSONString, true);

        // Merge CSV and JSON offers
        $offers = array_merge($offersCSV, $offersJSON);

        // Group by product_id
        $offersByProduct = $this->group_by('product_id', $offers);

        // Calculate average price for product
        $productsAverage = $this->averageForProduct($offersByProduct);

        // Return offers that are above average
        return $this->offersAboveAverage($offers, $productsAverage);
    }

    /**
     * Parse CSV file
     * @param string $fileName
     * @return array
     */
    private function parseCSV(string $fileName): array
    {
        $offerHeaders = [];
        $offers = [];

        if (($fp = fopen($fileName, "r")) !== FALSE) {
            $rowNo = 0;
            while (($row = fgetcsv($fp, 1000, ";")) !== FALSE) {
                $num = count($row);
                if($rowNo > 0){
                    //echo "<p> $num fields in line $rowNo: <br /></p>\n";
                    for ($c=0; $c < $num; $c++) {
                        //echo $row[$c] . "<br />\n";
                        $offers[$rowNo][$offerHeaders[$c]] = $row[$c];
                    }
                }else{
                    // First line
                    for ($c=0; $c < $num; $c++) {
                        //echo $row[$c] . "<br />\n";
                        $offerHeaders[$c] = $row[$c];
                    }
                }
                $rowNo++;
            }
            fclose($fp);
        }

        return $offers;
    }

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param string $key Property to sort by.
     * @param array $data Array that stores multiple associative arrays.
     * @return array
     */
    private function group_by(string $key, array $data): array
    {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }

    /**
     * Function that Calculate average price for product
     *
     * @param array $data
     * @return array
     */
    private function averageForProduct(array $data): array
    {
        $productsAverage = [];
        foreach ($data as $key => $products){
            $totalProducts = count($products);
            foreach ($products as $product) {
                if(empty($productsAverage[$key])){
                    // Validate price
                    if(is_numeric($product['price'])){
                        $productsAverage[$key] = $product['price']/$totalProducts;
                    }
                }else{
                    if(is_numeric($product['price'])){
                        $productsAverage[$key] += $product['price']/$totalProducts;
                    }
                }
            }
        }
        return $productsAverage;
    }

    /**
     * Function that search offers that are above average
     *
     * @param array $offers
     * @param array $productsAverage
     * @return array
     */
    private function offersAboveAverage(array $offers, array $productsAverage): array
    {
        $offersAboveAverage = [];

        foreach ($offers as $offer){
            if(
                $offer['price'] > $productsAverage[$offer['product_id']] + ($productsAverage[$offer['product_id']]*(self::AVERAGE / 100))
                || !is_numeric($offer['price'])
            ) {
                $offersAboveAverage[] = $offer;
            }
        }

        return $offersAboveAverage;
    }
}