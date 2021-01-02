<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use App\Voting;
class VotingCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mytime = Carbon::now();
        $checkVotePeriod = Voting::where([
            ['mulai', '<=', $mytime],
            ['berakhir', '>=', $mytime]
        ])->first();
        $dataVote = Voting::where('id', 1)->first();

        if($checkVotePeriod != null) {
            if($checkVotePeriod->result == 'pending'){
                return redirect('/')->with('periode','Pemilihan sedang ditunda untuk sementara waktu!');
            }
            return $next($request);
        } else {
            if($dataVote->result == 'berakhir'){
                return redirect('/hasilvote');
            }
            return redirect('/')->with('periode','Periode Belum dimulai atau sudah expired!');
        }
    }
}
