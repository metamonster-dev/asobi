<?php

namespace App\Services;

interface VimeoContentRepository
{
    /**
     * Vimeo 서버로부터 받은 vimeo의 video id를 업데이트 합니다.
     *
     * @param string $transactionId
     * @param string $videoId
     * @return void
     */
    public function uploadVimeoContentResult(string $transactionId, string $videoId, string $errorCode = null);

    /**
     * Vimeo 서버에서 삭제 처리된 content를 삭제합니다.
     *
     * @param string $transactionId
     * @return void
     */
    public function deleteVimeoContentResult(string $transactionId);
}
