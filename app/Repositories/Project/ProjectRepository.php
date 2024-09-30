<?php

namespace App\Repositories\Project;

use App\Models\Projeto;
use App\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectRepositoryContract
{
    public function __construct(Projeto $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $projectToSave = [
            'cliente_id' => data_get($data, 'cliente_id'),
            'nome' => data_get($data, 'nome'),
            'localizacao_id' => data_get($data, 'localizacao_id'),
            'tipo_instalacao_id' => data_get($data, 'tipo_instalacao_id'),
        ];

        $project = $this->model->create($projectToSave);

        if (!empty($data['equipamentos'])) {
            foreach ($data['equipamentos'] as $equipment) {
                $project->equipamentos()->attach($equipment['equipamento_id'], ['quantidade' => $equipment['quantidade']]);
            }
        }

        return $project;
    }
}
