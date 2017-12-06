<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Services\Payment\StripePaymentService;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plan = Plan::default();
        $planUK = Plan::where('stripe_id', Plan::STRIPE_ID_UK)->first();

        return view('admin.plan.index', compact('plan', 'planUK'));
    }

    public function changeDot(Request $request)
    {
        DB::table('plans')->update(['dot' => (int)$request->dot]);
        return response()->json('success');
    }

    public function update($id, Request $request)
    {
        $plan = Plan::default();
        $plan->amount = $request->input('amount') * 100;

        $planUK = Plan::where('stripe_id', Plan::STRIPE_ID_UK)->first();
        $planUK->amount = $request->input('amount_uk') * 100;

        if ($plan->save() && $planUK->save()) {
            if (!StripePaymentService::updatePlan($plan) || !StripePaymentService::updatePlan($planUK)) {
                flash('Error while updating plan!!!')->error();
                return back();
            }
            flash('Plan updated successfully!!!')->success();
            return redirect()->route('admin.plan.index');
        }
        flash('Error while updating plan!!!')->error();
        return back();
    }
}
