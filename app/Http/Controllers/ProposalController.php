<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProposalRequest;
use App\Models\JadwalPendaftaran;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Show list proposal view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('proposal.index', [
            'proposal' => Proposal::where('mahasiswa_id', auth()->user()->mahasiswa->id)->latest()->get(),
        ]);
    }

    /**
     * Show detail proposal view
     *
     * @param Proposal $proposal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Proposal $proposal)
    {
        return view('proposal.show', compact('proposal'));
    }

    /**
     * Show create proposal view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('proposal.create');
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
     * Show edit proposal view
     *
     * @param Proposal $proposal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Proposal $proposal)
    {
        return view('proposal.edit', compact('proposal'));
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

    /**
     * Handling download proposal request
     *
     * @param Proposal $proposal
     * @return mixed
     */
    public function download(Proposal $proposal)
    {
        return Storage::download($proposal->file_proposal, $proposal->mahasiswa->nim . ' Proposal.pdf');
    }

    /**
     * Handling download proposal request
     *
     * @param Proposal $proposal
     * @return mixed
     */
    public function stream(Proposal $proposal)
    {
        return Storage::download($proposal->file_proposal, $proposal->mahasiswa->nim . ' Proposal.pdf', [
            'Content-Type:' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $proposal->mahasiswa->nim . '"Proposal.pdf',
        ]);
    }

    public function send(Proposal $proposal)
    {
        return view('proposal.send', [
            'proposal' => $proposal,
            'jadwal_pendaftaran' => JadwalPendaftaran::active()->get(),
        ]);
    }
}
