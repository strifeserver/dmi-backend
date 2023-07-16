<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionPostRequest;

class TransactionsController extends Controller
{
    public function store(TransactionPostRequest $request)
    {

        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        $validated = $request->validated();
        $execution = $this->SurveyService->store($validated);

        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Created ' . $execution['message']
            );
    }

    public function update(TransactionPostRequest $request)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $validated = $request->validated();

        $execution = $this->SurveyService->update($validated);
        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Updated ' . $execution['message']
            );
    }
}
