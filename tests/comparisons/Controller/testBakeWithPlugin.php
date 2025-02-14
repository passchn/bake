<?php
declare(strict_types=1);

namespace BakeTest\Controller;

use Bake\Test\App\Controller\AppController;

/**
 * BakeArticles Controller
 *
 * @property \BakeTest\Model\Table\BakeArticlesTable $BakeArticles
 * @method \BakeTest\Model\Entity\BakeArticle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BakeArticlesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BakeUsers'],
        ];
        $bakeArticles = $this->paginate($this->BakeArticles);

        $this->set(compact('bakeArticles'));
    }

    /**
     * View method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bakeArticle = $this->BakeArticles->get($id, [
            'contain' => ['BakeUsers', 'BakeTags', 'BakeComments'],
        ]);

        $this->set(compact('bakeArticle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bakeArticle = $this->BakeArticles->newEmptyEntity();
        if ($this->request->is('post')) {
            $bakeArticle = $this->BakeArticles->patchEntity($bakeArticle, $this->request->getData());
            if ($this->BakeArticles->save($bakeArticle)) {
                $this->Flash->success(__('The bake article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bake article could not be saved. Please, try again.'));
        }
        $bakeUsers = $this->BakeArticles->BakeUsers->find('list', ['limit' => 200])->all();
        $bakeTags = $this->BakeArticles->BakeTags->find('list', ['limit' => 200])->all();
        $this->set(compact('bakeArticle', 'bakeUsers', 'bakeTags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bakeArticle = $this->BakeArticles->get($id, [
            'contain' => ['BakeTags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bakeArticle = $this->BakeArticles->patchEntity($bakeArticle, $this->request->getData());
            if ($this->BakeArticles->save($bakeArticle)) {
                $this->Flash->success(__('The bake article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bake article could not be saved. Please, try again.'));
        }
        $bakeUsers = $this->BakeArticles->BakeUsers->find('list', ['limit' => 200])->all();
        $bakeTags = $this->BakeArticles->BakeTags->find('list', ['limit' => 200])->all();
        $this->set(compact('bakeArticle', 'bakeUsers', 'bakeTags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bakeArticle = $this->BakeArticles->get($id);
        if ($this->BakeArticles->delete($bakeArticle)) {
            $this->Flash->success(__('The bake article has been deleted.'));
        } else {
            $this->Flash->error(__('The bake article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
