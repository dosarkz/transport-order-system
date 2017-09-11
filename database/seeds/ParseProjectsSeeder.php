<?php


class ParseProjectsSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->truncate();
        DB::table('projects')->delete();

        DB::table('project_operators')->truncate();
        DB::table('project_operators')->delete();

        DB::table('project_services')->truncate();
        DB::table('project_services')->delete();

        $projects = $this->parse('projects.json');

        if ($projects)
        {
            foreach ($projects as $project) {
                $user = \App\Models\User::where('_id', isset($project->userId) ? $project->userId : null)->first();

             $new_project =   \App\Models\Project::create([
                    'id' => $project->_id,
                   'name' => isset($project->name) ?  $project->name : null,
                   'company_type' =>  isset($project->rekvCompanyType) ?  $project->rekvCompanyType : null,
                   'company_name' => isset($project->rekvCompanyName) ?  $project->rekvCompanyName : null,
                   'company_name_full' =>  isset($project->rekvCompanyNameFull) ?  $project->rekvCompanyNameFull : null,
                   'director_name' => isset($project->rekvDirectorName) ?  $project->rekvDirectorName : null,
                   'f_director_name'  => isset($project->rekvFDirectorName) ?  $project->rekvFDirectorName : null,
                   'fact_address' => isset($project->rekvFactAddress) ?  $project->rekvFactAddress : null,
                   'legal_address'  =>  isset($project->rekvLegalAddress) ?  $project->rekvLegalAddress : null,
                   'phone' => isset($project->rekvPhone) ?  (int)$project->rekvPhone : null,
                   'email' => isset($project->rekvEmail) ?  $project->rekvEmail : null,
                   'description' =>  isset($project->rekvDescr) ?  $project->rekvDescr : null,
                   'bin'  =>   isset($project->rekvBin) ?  $project->rekvBin : null,
                   'bank_name' => isset($project->rekvBankName) ?  $project->rekvBankName : null,
                   'bank_account' => isset($project->rekvBankAccount) ?  $project->rekvBankAccount : null,
                   'bank_bik'  =>  isset($project->rekvBankBik) ?  $project->rekvBankBik : null,
                   'nds_value'  =>  isset($project->rekvNDSValue) ?  $project->rekvNDSValue : null,
                   'is_nds' =>  isset($project->rekvIsNDS) ?  $project->rekvIsNDS : null,
                   'user_id' => $user ? $user->id : 0,
               ]);

                if(isset($project->services))
                {
                    foreach ($project->services as $service) {
                        \App\Models\ProjectService::create([
                            '_id' => $service->id,
                            'name' => $service->name,
                            'project_id' => $new_project->id
                        ]);
                    }
                }

                if(isset($project->operatorList))
                {
                    foreach ($project->operatorList as $item) {
                        $user = \App\Models\User::where('_id', isset($item->uid) ? $item->uid : null)->first();
                        \App\Models\ProjectOperator::create([
                            'user_id' => $user->id,
                            'phone' => $item->phone,
                            'post_text' => $item->positionText,
                            'post_id' => $item->positionId,
                            'first_name' => $item->firstName,
                            'last_name' => $item->lastName,
                            'project_id' => $new_project->id,
                        ]);

                        \App\Models\UserRole::create([
                            'user_id' => $user->id,
                            'role_id' => \App\Models\Role::ROLE_OPERATOR
                        ]);
                    }
                }
           }
        }
    }



}
