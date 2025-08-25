<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Enums\RecoveryStatus;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->user()->type === 'admin' || request()->user()->type === 'staff') {
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        }
        $mot = request()->user()->mots()->where('status', JobStatus::Pending)->where('datetime', '>=', now())->orderBy('datetime');
        $data['mots'] = $mot->take(3)->get();
        $data['mots_count'] = $mot->count();

        $service = request()->user()->services()->where('status', JobStatus::Pending)->where('datetime', '>=', now())->orderBy('datetime');
        $data['services'] = $service->take(3)->get();
        $data['services_count'] = $service->count();

        $repair = request()->user()->repairs()->where('status', JobStatus::Pending)->whereNotNull('datetime')->where('datetime', '>=', now())->orderBy('datetime');
        $data['repairs'] = $repair->take(3)->get();
        $data['repairs_count'] = $repair->count();

        $data['quotes'] = request()->user()->repairs()->whereIn('job_approval', ['requested', 'pending', 'approved'])->whereNull('datetime')->latest('updated_at')->get();

        $recovery = request()->user()->recoveries()->whereNot('status', RecoveryStatus::Completed)->withCount(['quotes', 'completer'])->whereHas('completer')->latest();
        $data['recoveries'] = $recovery->take(3)->get();
        $data['recoveries_count'] = $recovery->count();
        $data['recoveries_quotes'] = request()->user()->recoveries()->withCount('quotes')->doesntHave('completer')->latest()->get();

        return view('dashboard', compact('data'));
    }

    /**
     * account
     *
     * @return view
     */
    public function account()
    {
        return view('account');
    }

    public function updateAccount(AccountUpdateRequest $request)
    {
        // $request->safe()->only(['name', 'email'])
        $request->user()->update($request->safe()->except(['password']));

        if ($request->password) {
            $request->user()->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->back()->with('success', trans('general.user_updated'));
    }

    public function language($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);

        return back();
    }
}
