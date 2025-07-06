<?php
namespace App\Http\Helpers;

use Illuminate\Http\Request;
use App\Models\Settings\MailCode;
use App\Models\Settings\Sequence;
use App\Models\Settings\DosirOut;
use App\Models\Masters\OutBox;
// use App\Models\Inventory\Equipment;
// use App\Models\Inventory\Catalog;
// use App\Models\Inventory\Goods;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class GeneralHelper{

    public static function addMailNumber($data)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {

            $formatNumberCode   = FormatNumberCode::find($data);
            $formatNumber       = explode('/', $formatNumberCode->format);
            $now                = Carbon::now();

            $currentMonth       = self::monthToRoman($now->format('m'));
            $currentYear        = $now->format('Y');

            if($formatNumberCode->restart_every == 'month'){
                $placeholdersToRemove = ['{no}'];
            } else {
                $placeholdersToRemove = ['{no}', '{bulan}'];
            }
            
            $skey    = self::formatString($formatNumberCode->format, $placeholdersToRemove);

            // add sequence for no
            $noSeq      = 1;
            $sequence   = Sequence::where('skey', $skey)->first();
            if(isset($sequence->sequence)){
                $noSeq  = $sequence->sequence + 1;
            }

            Sequence::updateOrInsert(['skey' => $skey],['sequence' => $noSeq]);

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($success_trans == true) {

            $formatNo   = self::replacePlaceholders($formatNumberCode->format, $noSeq, $currentMonth, $currentYear);
            return $formatNo;
        }

    }

    public static function monthToRoman($month) {
        $romanNumerals = [
            'I', 'II', 'III', 'IV', 'V', 'VI',
            'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];
        return $romanNumerals[$month - 1] ?? 'Unknown';
    }
    
    public static function formatString($format, $placeholdersToRemove) {
        // Remove each placeholder specified in $placeholdersToRemove
        // dd($format, $placeholdersToRemove);
        $result = str_replace($placeholdersToRemove, '', $format);
        
        // Replace {tahun} with the current year
        $currentYear = date('Y');
        $result = str_replace('{tahun}', $currentYear, $result);
        
        // Optionally trim any extra slashes or spaces left after removal
        $result = trim($result, '/');
        
        return $result;
    }

    // Function to replace placeholders with dynamic data
    public static function replacePlaceholders($format, $seq, $month, $year) {
        // Define the placeholders and their corresponding values
        $placeholders = ['{no}', '{bulan}', '{tahun}'];
        $values = [$seq, $month, $year];

        // Replace placeholders with dynamic values
        $result = str_replace($placeholders, $values, $format);

        return $result;
    }

    public static function autoNumbering($skey)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            // add sequence for no
            $noSeq      = 1;
            $sequence   = Sequence::where('skey', $skey)->first();
            if(isset($sequence->sequence)){
                $noSeq  = $sequence->sequence + 1;
            }

            Sequence::updateOrInsert(['skey' => $skey],['sequence' => $noSeq]);

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return $noSeq;
        }

        if ($success_trans == true) {
            return $noSeq;
        }
    }

}