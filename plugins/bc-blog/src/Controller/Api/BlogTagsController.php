<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */
namespace BcBlog\Controller\Api;

use BaserCore\Controller\Api\BcApiController;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BaserCore\Error\BcException;
use BcBlog\Service\BlogTagsService;
use BcBlog\Service\BlogTagsServiceInterface;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * BlogTagsController
 */
class BlogTagsController extends BcApiController
{

    /**
     * [ADMIN] タグ登録
     */
    public function add(BlogTagsServiceInterface $service)
    {
        if ($this->request->is('post')) {
            try {
                /* @var \BcBlog\Service\BlogTagsService $service */
                $blogTag = $service->create($this->request->getData());
                $message = __d('baser', 'ブログタグ「{0}」を追加しました。', $blogTag->name);
            } catch (PersistenceFailedException $e) {
                $blogTag = $e->getEntity();
                $this->setResponse($this->response->withStatus(400));
                $message = __d('baser', '入力エラーです。内容を修正してください。');
            }
            $this->set([
                'message' => $message,
                'blogTag' => $blogTag,
                'errors' => $blogTag->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'blogTag', 'errors']);
        }
    }

    /**
     * バッチ処理
     *
     * @param BlogTagsService $service
     * @checked
     * @noTodo
     */
    public function batch(BlogTagsServiceInterface $service)
    {
        $this->request->allowMethod(['post', 'put']);
        $allowMethod = [
            'delete' => '削除',
        ];
        $method = $this->getRequest()->getData('batch');
        if (!isset($allowMethod[$method])) {
            $this->setResponse($this->response->withStatus(500));
            $this->viewBuilder()->setOption('serialize', []);
            return;
        }
        $targets = $this->getRequest()->getData('batch_targets');
        try {
            $names = $service->getTitlesById($targets);
            $service->batch($method, $targets);
            $this->BcMessage->setSuccess(
                sprintf(__d('baser', 'ブログタグ「%s」を %s しました。'), implode('」、「', $names), $allowMethod[$method]),
                true,
                false
            );
            $message = __d('baser', '一括処理が完了しました。');
        } catch (BcException $e) {
            $this->setResponse($this->response->withStatus(400));
            $message = __d('baser', $e->getMessage());
        }
        $this->set(['message' => $message]);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

}
