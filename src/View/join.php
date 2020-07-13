<div class="container py-5">
    <form id="register_form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="register_email">이메일</label>
            <input type="email" id="register_email" class="form-control" name="email" required>
        </div>
        <small class="text text-danger" id="email_danger"></small>

        <div class="form-group">
            <label for="register_password">비밀번호</label>
            <input type="password" id="register_password" class="form-control" name="password" required>
        </div>
        <small class="text text-danger" id="password_danger"></small>

        <div class="form-group">
            <label for="register_password_check">비밀번호 확인</label>
            <input type="password" id="register_password_check" class="form-control" name="password_check" required>
        </div>
        <small class="text text-danger" id="password_check_danger"></small>

        <div class="form-group">
            <label for="register_profile">프로필 사진</label>
            <div class="custom-file">
                <input type="file" id="register_profile" class="custom-file-input" name="profile" required>
                <label for="register_profile" class="custom-file-label"></label>
            </div>
        </div>
        <small class="text text-danger" id="profile_danger"></small>

        <div class="form-group">
            <label for="register_name">이름</label>
            <input type="text" id="register_name" class="form-control" name="name" required>
        </div>
        <small class="text text-danger" id="name_danger"></small>

        <div class="form-group">
            <label for="register_type">회원 유형</label>
            <select name="type" id="register_type" class="form-control">
                <option value="normal">일반 회원</option>
                <option value="company">기업 회원</option>
            </select>
        </div>
        <input type="submit" id="register_submit" class="form-control" value="회원가입">
    </form>
</div>

<script src="/js/register.js"></script>