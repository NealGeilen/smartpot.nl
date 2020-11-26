<?php
namespace App\Helpers;

use Endroid\QrCode\QrCode;

class QRHelper{
    /**
     * @param string $sHref
     * @param null $sCacheFile
     * @return mixed
     */
    public static function Create($sContent= "")
    {
        $qrCode = new QrCode($sContent);
        $qrCode->setSize(300);
        $qrCode->setForegroundColor(["r" => 0,"g"=>168,"b" => 150]);
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK);

        return  $qrCode->writeDataUri();
    }
}