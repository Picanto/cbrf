<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cbrf;
use Illuminate\Http\Request;

class CbrfController extends Controller
{
    //
    public function index() {

        $xml_string = '<ValCurs Date="20.04.2023" name="Foreign Currency Market">
<Valute ID="R01010">
<NumCode>036</NumCode>
<CharCode>AUD</CharCode>
<Nominal>1</Nominal>
<Name>Австралийский доллар</Name>
<Value>54,9293</Value>
</Valute>
<Valute ID="R01020A">
<NumCode>944</NumCode>
<CharCode>AZN</CharCode>
<Nominal>1</Nominal>
<Name>Азербайджанский манат</Name>
<Value>48,0323</Value>
</Valute>
<Valute ID="R01035">
<NumCode>826</NumCode>
<CharCode>GBP</CharCode>
<Nominal>1</Nominal>
<Name>Фунт стерлингов Соединенного королевства</Name>
<Value>101,4807</Value>
</Valute>
<Valute ID="R01060">
<NumCode>051</NumCode>
<CharCode>AMD</CharCode>
<Nominal>100</Nominal>
<Name>Армянских драмов</Name>
<Value>21,0635</Value>
</Valute>
<Valute ID="R01090B">
<NumCode>933</NumCode>
<CharCode>BYN</CharCode>
<Nominal>1</Nominal>
<Name>Белорусский рубль</Name>
<Value>27,7351</Value>
</Valute>
<Valute ID="R01100">
<NumCode>975</NumCode>
<CharCode>BGN</CharCode>
<Nominal>1</Nominal>
<Name>Болгарский лев</Name>
<Value>45,8066</Value>
</Valute>
<Valute ID="R01115">
<NumCode>986</NumCode>
<CharCode>BRL</CharCode>
<Nominal>1</Nominal>
<Name>Бразильский реал</Name>
<Value>16,4378</Value>
</Valute>
<Valute ID="R01135">
<NumCode>348</NumCode>
<CharCode>HUF</CharCode>
<Nominal>100</Nominal>
<Name>Венгерских форинтов</Name>
<Value>23,7128</Value>
</Valute>
<Valute ID="R01150">
<NumCode>704</NumCode>
<CharCode>VND</CharCode>
<Nominal>10000</Nominal>
<Name>Вьетнамских донгов</Name>
<Value>34,5615</Value>
</Valute>
<Valute ID="R01200">
<NumCode>344</NumCode>
<CharCode>HKD</CharCode>
<Nominal>1</Nominal>
<Name>Гонконгский доллар</Name>
<Value>10,4198</Value>
</Valute>
<Valute ID="R01210">
<NumCode>981</NumCode>
<CharCode>GEL</CharCode>
<Nominal>1</Nominal>
<Name>Грузинский лари</Name>
<Value>32,4066</Value>
</Valute>
<Valute ID="R01215">
<NumCode>208</NumCode>
<CharCode>DKK</CharCode>
<Nominal>1</Nominal>
<Name>Датская крона</Name>
<Value>12,0236</Value>
</Valute>
<Valute ID="R01230">
<NumCode>784</NumCode>
<CharCode>AED</CharCode>
<Nominal>1</Nominal>
<Name>Дирхам ОАЭ</Name>
<Value>22,2335</Value>
</Valute>
<Valute ID="R01235">
<NumCode>840</NumCode>
<CharCode>USD</CharCode>
<Nominal>1</Nominal>
<Name>Доллар США</Name>
<Value>81,6549</Value>
</Valute>
<Valute ID="R01239">
<NumCode>978</NumCode>
<CharCode>EUR</CharCode>
<Nominal>1</Nominal>
<Name>Евро</Name>
<Value>89,3736</Value>
</Valute>
<Valute ID="R01240">
<NumCode>818</NumCode>
<CharCode>EGP</CharCode>
<Nominal>10</Nominal>
<Name>Египетских фунтов</Name>
<Value>26,4311</Value>
</Valute>
<Valute ID="R01270">
<NumCode>356</NumCode>
<CharCode>INR</CharCode>
<Nominal>100</Nominal>
<Name>Индийских рупий</Name>
<Value>99,4928</Value>
</Valute>
<Valute ID="R01280">
<NumCode>360</NumCode>
<CharCode>IDR</CharCode>
<Nominal>10000</Nominal>
<Name>Индонезийских рупий</Name>
<Value>55,2731</Value>
</Valute>
<Valute ID="R01335">
<NumCode>398</NumCode>
<CharCode>KZT</CharCode>
<Nominal>100</Nominal>
<Name>Казахстанских тенге</Name>
<Value>18,1053</Value>
</Valute>
<Valute ID="R01350">
<NumCode>124</NumCode>
<CharCode>CAD</CharCode>
<Nominal>1</Nominal>
<Name>Канадский доллар</Name>
<Value>60,9957</Value>
</Valute>
<Valute ID="R01355">
<NumCode>634</NumCode>
<CharCode>QAR</CharCode>
<Nominal>1</Nominal>
<Name>Катарский риал</Name>
<Value>22,4327</Value>
</Valute>
<Valute ID="R01370">
<NumCode>417</NumCode>
<CharCode>KGS</CharCode>
<Nominal>100</Nominal>
<Name>Киргизских сомов</Name>
<Value>93,2986</Value>
</Valute>
<Valute ID="R01375">
<NumCode>156</NumCode>
<CharCode>CNY</CharCode>
<Nominal>1</Nominal>
<Name>Китайский юань</Name>
<Value>11,8178</Value>
</Valute>
<Valute ID="R01500">
<NumCode>498</NumCode>
<CharCode>MDL</CharCode>
<Nominal>10</Nominal>
<Name>Молдавских леев</Name>
<Value>45,5625</Value>
</Valute>
<Valute ID="R01530">
<NumCode>554</NumCode>
<CharCode>NZD</CharCode>
<Nominal>1</Nominal>
<Name>Новозеландский доллар</Name>
<Value>50,6505</Value>
</Valute>
<Valute ID="R01535">
<NumCode>578</NumCode>
<CharCode>NOK</CharCode>
<Nominal>10</Nominal>
<Name>Норвежских крон</Name>
<Value>77,4171</Value>
</Valute>
<Valute ID="R01565">
<NumCode>985</NumCode>
<CharCode>PLN</CharCode>
<Nominal>1</Nominal>
<Name>Польский злотый</Name>
<Value>19,3175</Value>
</Valute>
<Valute ID="R01585F">
<NumCode>946</NumCode>
<CharCode>RON</CharCode>
<Nominal>1</Nominal>
<Name>Румынский лей</Name>
<Value>18,0873</Value>
</Valute>
<Valute ID="R01589">
<NumCode>960</NumCode>
<CharCode>XDR</CharCode>
<Nominal>1</Nominal>
<Name>СДР (специальные права заимствования)</Name>
<Value>110,1680</Value>
</Valute>
<Valute ID="R01625">
<NumCode>702</NumCode>
<CharCode>SGD</CharCode>
<Nominal>1</Nominal>
<Name>Сингапурский доллар</Name>
<Value>61,2335</Value>
</Valute>
<Valute ID="R01670">
<NumCode>972</NumCode>
<CharCode>TJS</CharCode>
<Nominal>10</Nominal>
<Name>Таджикских сомони</Name>
<Value>74,8173</Value>
</Valute>
<Valute ID="R01675">
<NumCode>764</NumCode>
<CharCode>THB</CharCode>
<Nominal>10</Nominal>
<Name>Таиландских батов</Name>
<Value>23,7795</Value>
</Valute>
<Valute ID="R01700J">
<NumCode>949</NumCode>
<CharCode>TRY</CharCode>
<Nominal>10</Nominal>
<Name>Турецких лир</Name>
<Value>42,1053</Value>
</Valute>
<Valute ID="R01710A">
<NumCode>934</NumCode>
<CharCode>TMT</CharCode>
<Nominal>1</Nominal>
<Name>Новый туркменский манат</Name>
<Value>23,3300</Value>
</Valute>
<Valute ID="R01717">
<NumCode>860</NumCode>
<CharCode>UZS</CharCode>
<Nominal>10000</Nominal>
<Name>Узбекских сумов</Name>
<Value>71,4017</Value>
</Valute>
<Valute ID="R01720">
<NumCode>980</NumCode>
<CharCode>UAH</CharCode>
<Nominal>10</Nominal>
<Name>Украинских гривен</Name>
<Value>22,1095</Value>
</Valute>
<Valute ID="R01760">
<NumCode>203</NumCode>
<CharCode>CZK</CharCode>
<Nominal>10</Nominal>
<Name>Чешских крон</Name>
<Value>38,3140</Value>
</Valute>
<Valute ID="R01770">
<NumCode>752</NumCode>
<CharCode>SEK</CharCode>
<Nominal>10</Nominal>
<Name>Шведских крон</Name>
<Value>79,0938</Value>
</Valute>
<Valute ID="R01775">
<NumCode>756</NumCode>
<CharCode>CHF</CharCode>
<Nominal>1</Nominal>
<Name>Швейцарский франк</Name>
<Value>90,8791</Value>
</Valute>
<Valute ID="R01805F">
<NumCode>941</NumCode>
<CharCode>RSD</CharCode>
<Nominal>100</Nominal>
<Name>Сербских динаров</Name>
<Value>76,3589</Value>
</Valute>
<Valute ID="R01810">
<NumCode>710</NumCode>
<CharCode>ZAR</CharCode>
<Nominal>10</Nominal>
<Name>Южноафриканских рэндов</Name>
<Value>44,6763</Value>
</Valute>
<Valute ID="R01815">
<NumCode>410</NumCode>
<CharCode>KRW</CharCode>
<Nominal>1000</Nominal>
<Name>Вон Республики Корея</Name>
<Value>61,5938</Value>
</Valute>
<Valute ID="R01820">
<NumCode>392</NumCode>
<CharCode>JPY</CharCode>
<Nominal>100</Nominal>
<Name>Японских иен</Name>
<Value>60,8911</Value>
</Valute>
</ValCurs>';

        $xml = simplexml_load_string($xml_string);

        $json = json_encode($xml);

        $array = json_decode($json,TRUE);

        $count = count($array['Valute']);

        return $array['Valute'][$count-1];

        // return 1; // Cbrf::all();
    }
}
