<?php

namespace App\Jobs;

use App\AdviceFile;
use App\AdviceNote;
use App\AppendFile;
use App\Http\Controllers\VimeoController;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class BatchPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $type;
    protected $user;
    protected $title;
    protected $content;
    protected $class_content;
    protected $year;
    protected $month;
    protected $day;
    protected $this_month;
    protected $next_month;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student, $type, $user, $title, $content, $class_content, $year, $month, $day, $this_month, $next_month, $request)
    {
        //
        $this->student = $student;
        $this->type = $type;
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
        $this->class_content = $class_content;
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->this_month = $this_month;
        $this->next_month = $next_month;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach ($this->student as $l) {
            if ($this->type == AdviceNote::ADVICE_TYPE) {
                $student_row = RaonMember::whereId($l)->first();
                if ($student_row) {
                    $this->title = $student_row->name . "의 선생님이 알립니다.";
                }
            }
            $payload = [
                'type' => $this->type,
                'hidx' => $this->user->branch_id,
                'midx' => $this->user->id,
                'sidx' => $l,
                'title' => $this->title,
                'content' => $this->content,
                'class_content' => $this->class_content,
                'year' => $this->year,
                'month' => $this->month,
                'day' => $this->day,
                'this_month' => $this->this_month,
                'next_month' => $this->next_month,
                'status' => 'Y',
                'batch' => 'N'
            ];

            $adviceNote = new AdviceNote($payload);
            $adviceNote->save();

            //임시파일 업로드
            $tmp_upload = $this->request->input('upload_files');
            $upload_files = $this->request->file('upload_files');
            if ($tmp_upload) {
                if ($upload_files && is_array($upload_files)) {
                    $upload_files = array_merge($tmp_upload, $upload_files);
                } else {
                    $upload_files = $tmp_upload;
                }
            }
            if ($upload_files) {
                $vimeo = new VimeoController();
                foreach ($upload_files as $file) {
                    $file_name = $file->getClientOriginalName();
                    $vimeo_id = null;

                    if (Str::startsWith($file->getMimeType(), 'video')) {
                        $vimeo_id = $vimeo->upload_simple($file);
                    }

                    if ($vimeo_id) {
                        $file_path = AppendFile::getVimeoThumbnailUrl($vimeo_id);
                    } else {
                        $file_path = \App::make('helper')->putResizeS3(AdviceFile::FILE_DIR, $file);
                    }

                    $adviceNote->files()->create(
                        [
                            'file_name' => $file_name,
                            'file_path' => $file_path,
                            'file_size' => $file->getSize(),
                            'file_mimetype' => $file->getMimeType(),
                            'vimeo_id' => $vimeo_id
                        ]
                    );
                }
            }

            BatchPush::dispatch(['type' => $adviceNote->type, 'type_id' => $adviceNote->id, 'param' => []]);
        }
    }
}
