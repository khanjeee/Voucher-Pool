<?php
namespace App\Http\Controllers;
use App\DataTypes\DTToken;
use App\Constants\Constants;
use Disrupt\Common\DataTypes\DTResponse;
use App\Helper\Helper;
use App\DataTypes\DTServer;
use App\Models\Reseller;
use App\Models\SpeedTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="",
 *     @SWG\Info(
 *         version="1.0",
 *         title="Voucher Pool",
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */

class ApiController extends Controller
{
    public function __construct()
    {
        //do something with me ;)
    }


    /**
     * @SWG\Get(
     *     path="/generatePromo",
     *     summary="Generates promo code",
     *     operationId="generatePromo",
     *     tags={"promos"},
     *
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *
     *     )
     * )
     */

    public function generatePromo()
    {

    }
}