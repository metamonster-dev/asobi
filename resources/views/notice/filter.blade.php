<!-- 공지사항 필터 -->
<div class="filter_modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4 class="tit_h4 py-4 border-bottom border-text">필터 선택</h4>
                <button class="btn btn-block h-auto px-0 py-4 border-bottom active" value="" onclick="filterChange(this.value)">
                    <p class="py-2 fs_16 fw_400">전체보기</p>
                </button>
                <button class="btn btn-block h-auto px-0 py-4 border-bottom mt-0" value="m" onclick="filterChange(this.value)">
                    <p class="py-2 fs_16 fw_400">교육원 공지사항만 보기</p>
                </button>
                <button class="btn btn-block h-auto px-0 py-4 mt-0" value="a" onclick="filterChange(this.value)">
                    <p class="py-2 fs_16 fw_400">본사 공지사항만 보기</p>
                </button>
            </div>
        </div>
    </div>
</div>