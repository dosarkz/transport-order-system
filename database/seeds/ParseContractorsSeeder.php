<?php


class ParseContractorsSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contractors')->truncate();
        DB::table('contractors')->delete();

        $parse_models = $this->parse('contractors.json');

        if ($parse_models)
        {
            foreach ($parse_models as $item) {

                $user =  \App\Models\User::where('_id', isset($item->userId) ? $item->userId : null)->first();
                $project = \App\Models\Project::find(isset($item->projectId) ? $item->projectId : null);

                \App\Models\Contractor::create([
                    'id' => $item->_id,
                    'company_type' => isset($item->rekvCompanyType) ? $item->rekvCompanyType : null,
                    'company_name' => isset($item->rekvCompanyName) ? $item->rekvCompanyName : null,
                    'company_name_full' => isset($item->rekvCompanyNameFull) ? $item->rekvCompanyNameFull : null,
                    'director_name' => isset($item->rekvDirectorName) ? $item->rekvDirectorName : null,
                    'f_director_name' => isset($item->rekvFDirectorName) ? $item->rekvFDirectorName : null,
                    'fact_address' => isset($item->rekvFactAddress) ? $item->rekvFactAddress : null,
                    'legal_address' => isset($item->rekvLegalAddress) ? $item->rekvLegalAddress : null,
                    'phone' => isset($item->rekvPhone) ? $item->rekvPhone != '' ? purify_phone_number($item->rekvPhone) : null : null,
                    'email' => isset($item->rekvEmail) ? $item->rekvEmail : null,
                    'description' => isset($item->rekvDescr) ? $item->rekvDescr : null,
                    'bin' => isset($item->rekvBin) ? $item->rekvBin : null,
                    'bank_name'  => isset($item->rekvBankName) ? $item->rekvBankName : null,
                    'bank_account'  => isset($item->rekvBankAccount) ? $item->rekvBankAccount : null,
                    'bank_bik'   => isset($item->rekvBankBik) ? $item->rekvBankBik : null,
                    'nds_value'   => isset($item->rekvNDSValue) ? $item->rekvNDSValue : null,
                    'is_nds'    => isset($item->rekvIsNDS) ? $item->rekvIsNDS : null,
                    'user_id'  => $user ? $user->id : null,
                    'project_id' => $project ? $project->id : null,
                    'is_provider' =>  isset($item->isProvider) ? $item->isProvider : null,
                ]);

                if(isset($item->documents))
                {
                    foreach ($item->documents as $document) {

                      $file =   \App\Models\File::create([
                            'url' => $document->ufile->url,
                            'etag' => $document->ufile->etag,
                            '_public_id' => $document->ufile->public_id
                        ]);
                        $user = \App\Models\User::where('_id', $document->createdBy)->first();

                        \App\Models\ContractorDocument::create([
                            '_id'  => isset($document->recId) ? $document->recId : null,
                            'start_at'  => isset($document->fileStartDate) ? date('Y-m-d H:i:s', $document->fileStartDate) : null,
                            'stop_at'  => isset($document->fileEndDate) ? date('Y-m-d H:i:s', $document->fileEndDate) : null,
                            'file_type' => isset($document->fileType) ? $document->fileType : null,
                            'file_type_name'  => isset($document->fileTypeName) ? $document->fileTypeName : null,
                            'file_number'  => isset($document->fileNumber) ? $document->fileNumber != '' ? $document->fileNumber : null : null,
                            'file_price' => isset($document->filePrice) ? $document->filePrice != '' ? $document->filePrice : null : null,
                            'description' => isset($document->fileDescription) ? $document->fileDescription : null,
                            'file_extension'  => isset($document->fileExt) ? $document->fileExt : null,
                            'file_id' => $file->id,
                            'user_id' => $user ? $user->id : null,
                        ]);


                    }
                }

           }
        }
    }



}
