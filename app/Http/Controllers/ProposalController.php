<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProposalRequest;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function index()
    {
        return view('proposal.index', [
            'proposal' => Proposal::latest(),
        ]);
    }
    /**
     * Handling incoming store request
     *
     * @param ProposalRequest $request
     * @return mixed
     */
    public function store(ProposalRequest $request)
    {
        $data = $request->validated();
        $data['mahasiswa_id'] = auth()->user()->mahasiswa->id;
        $data['file_proposal'] = $request->uploadProposal();

        Proposal::create($data);

        return redirect()->route('proposal.index')->with([
            'success' => 'Berhasil menambahkan proposal'
        ]);
    }

    /**
     * Handling incoming update request
     *
     * @param ProposalRequest $request
     * @param Proposal $proposal
     * @return mixed
     */
    public function update(ProposalRequest $request, Proposal $proposal)
    {
        $data = $request->validated();

        if ($request->hasFile('file_proposal')) {
            Storage::delete($proposal->file_proposal);
            $data['file_proposal'] = $request->uploadProposal();
        }

        $proposal->update($data);

        return redirect()->route('proposal.edit', $proposal)->with([
            'success' => 'Berhasil mengubah proposal'
        ]);
    }

    /**
     * Handling incoming delete request
     *
     * @param Proposal $proposal
     * @return mixed
     */
    public function destroy(Proposal $proposal)
    {
        $this->authorize('delete', $proposal);

        Storage::delete($proposal->file_proposal);

        $proposal->delete();

        return redirect()->route('proposal.index')->with([
            'success' => 'Berhasil menghapus proposal'
        ]);
    }
}
