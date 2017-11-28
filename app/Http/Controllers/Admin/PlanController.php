<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Services\Payment\StripePaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plan = Plan::default();
        return view('admin.plan.index', compact('plan'));
    }

    public function update($id, Request $request)
    {
        $plan = Plan::findOrFail($id);
        $plan->amount = $request->input('amount') * 100;
        if ($plan->save()) {
            if (!StripePaymentService::updatePlan($plan)) {
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
