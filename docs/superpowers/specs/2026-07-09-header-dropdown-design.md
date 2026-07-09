# Thiết kế: Dropdown menu con trên header

Ngày: 2026-07-09
Trạng thái: đã duyệt, chờ lập kế hoạch triển khai

## Mục tiêu

Ba mục menu header — "Về ECS", "Lĩnh vực hoạt động", "Phát triển bền vững" — khi
hover trên desktop sẽ xổ ra một panel chứa các mục con của riêng nó. Ba mục còn
lại (Tin tức, Tuyển dụng, Liên hệ) không có mục con và render y như hiện tại.

Trên mobile (không có hover) mục cha có nút caret riêng để bấm xổ accordion; bấm
vào chữ vẫn điều hướng tới trang cha.

## Quyết định đã chốt

| Vấn đề | Lựa chọn |
|---|---|
| Kiểu panel | Dropdown riêng từng mục, neo dưới mục cha (KHÔNG phải một mega-panel 3 cột dùng chung) |
| Nguồn dữ liệu | WP menu (Appearance → Menus) + fallback tĩnh trong `inc/data.php` |
| Mobile | Accordion bấm mở, class `.is-open` / `.is-hidden` |
| Href mục con | Trọng tâm là dropdown chạy đúng; 4 mục của "Về ECS" dùng anchor thật, 8 mục còn lại trỏ về trang cha |
| Cơ chế mở (desktop) | CSS thuần `:hover` + `:focus-within`, không JS |

### Vì sao CSS thuần thay vì JS

CLAUDE.md quy định theme dùng progressive enhancement (gate `.js`, "content is
visible if JS fails"). Hover mở bằng CSS là cách duy nhất không phụ thuộc JS,
không có bug trạng thái, và `:focus-within` cho phép người dùng bàn phím Tab vào
để mở, Tab ra để đóng.

Đánh đổi: không đóng được bằng phím Esc. Chấp nhận, vì Tab-ra-ngoài đã đóng.

JS chỉ dùng đúng chỗ thật sự cần: accordion mobile.

## Nội dung mục con

**Về ECS** (anchor thật trên `/ve-ecs`)
- Hành trình phát triển → `/ve-ecs#hanh-trinh-phat-trien` (id đã có)
- Tầm nhìn → `/ve-ecs#tam-nhin` (**phải thêm id**)
- Sứ mệnh → `/ve-ecs#su-menh` (**phải thêm id**)
- Giá trị cốt lõi → `/ve-ecs#gia-tri-cot-loi` (id đã có)

**Lĩnh vực hoạt động** (đều trỏ `/linh-vuc-hoat-dong/`)
- Hướng nghiệp, Tuyển sinh, Đào tạo, Việc làm, Truyền thông

**Phát triển bền vững** (đều trỏ `/phat-trien-ben-vung/`)
- Văn hoá ECS, Con người ECS, Trách nhiệm xã hội

## Các thành phần

### 1. Tầng dữ liệu

`ecsges_nav_items()` (`inc/data.php:17`) thêm khoá `children` cho 3 mục. Mục
không có con thì không có khoá `children`.

`ecsges_get_nav()` (`functions.php:376`) hiện **bỏ qua** mục con
(`menu_item_parent !== 0 → continue`). Đổi thành gom cây hai lượt:

1. Lượt một: mục cha (`menu_item_parent == 0`) vào map theo `ID`.
2. Lượt hai: mục con đẩy vào `children` của cha tương ứng.

Fallback tĩnh và `ecsges_tr_deep()` giữ nguyên — hàm này đã đệ quy (`inc/i18n.php:203`)
nên nhãn mục con tự dịch qua Polylang, không cần sửa gì thêm.

Hợp đồng: `ecsges_get_nav()` trả về mảng, mỗi phần tử
`array( 'label' => string, 'href' => string, 'children' => array|absent )`.
`children` có cùng shape nhưng không lồng sâu thêm (chỉ 2 cấp).

### 2. Markup — `header.php`

Desktop nav (`header.php:44`):

```php
<li class="ecs-header__nav-item<?php echo $has_children ? ' has-children' : ''; ?>">
  <a href="…" class="ecs-header__nav-link">
    <?php echo esc_html( $item['label'] ); ?>
    <?php if ( $has_children ) echo ecsges_icon( 'chevron-down', 13, 'ecs-header__nav-caret', 2.5 ); ?>
  </a>
  <?php if ( $has_children ) : ?>
    <div class="ecs-header__dropdown">
      <ul class="ecs-header__dropdown-list">
        <li><a href="…" class="ecs-header__dropdown-link">…</a></li>
      </ul>
    </div>
  <?php endif; ?>
</li>
```

Panel là `<div>` bọc ngoài `<ul>` để `padding-top` làm **cầu chuột**: không có nó,
khoảng hở giữa link và panel sẽ ngắt `:hover` khi rê chuột xuống. Đây đúng là thủ
thuật `.ecsges-lang-panel` đang dùng (`_layout.scss:337`).

Mobile nav (`header.php:84`): mục có con thành hàng ngang — link cha giữ nguyên,
cạnh nó là `<button class="ecs-header__mobile-sub-toggle" aria-expanded="false"
aria-controls="submenu-N">` chứa caret, rồi `<ul id="submenu-N"
class="ecs-header__mobile-sublist is-hidden">`.

A11y: link cha desktop **không** mang `aria-expanded` (sẽ nói dối vì không có JS
cập nhật). Chỉ `<button>` mobile mang `aria-expanded` và được JS toggle thật.

### 3. SCSS — `src/scss/components/_layout.scss`

Thêm vào block `.ecs-header` sẵn có, ngay sau `&__nav-link`:

```scss
&__nav-item { position: relative; }

&__dropdown {
  position: absolute; left: 0; top: 100%; z-index: 50;
  padding-top: 0.75rem;              // cầu chuột
  opacity: 0; visibility: hidden;    // không display:none → transition được
  transition: opacity .2s ease, visibility .2s ease;
}

&__nav-item:hover &__dropdown,
&__nav-item:focus-within &__dropdown { opacity: 1; visibility: visible; }
```

Ràng buộc:

- Dùng `visibility` chứ không `display: none` — `display` không transition được,
  và `:focus-within` cần phần tử ở trong luồng focus.
- `&__nav-item:hover &__dropdown` nở thành
  `.ecs-header__nav-item:hover .ecs-header__dropdown`. Nếu Dart Sass báo lỗi khi
  lồng `&__` trong selector con, viết tường minh tên class đầy đủ.

Panel: nền trắng, `border-radius`, `box-shadow`, `min-width: 220px`,
`white-space: nowrap`. Link con `font-size: 15px`, `color: $ink`, `hover → $brand`.
Caret xoay 180° khi mở, giống `.ecsges-lang-caret`.

Mobile sublist dùng `.is-hidden` sẵn có và `.is-open` trên `<li>` để xoay caret —
khớp quy ước "SCSS định nghĩa state, JS chỉ toggle class" trong CLAUDE.md.

`.ecs-header__row` không có `overflow: hidden` nên panel không bị cắt. Panel dùng
`z-index: 50` cùng mức `.ecsges-lang-panel`, hai cái không chồng lấn vị trí.

### 4. JS — `assets/js/main.js`

Một hàm `initMobileSubmenu()`, gọi trong `DOMContentLoaded` cạnh `initLangDropdown()`:

```js
function initMobileSubmenu() {
  var toggles = document.querySelectorAll('[data-submenu-toggle]');
  Array.prototype.forEach.call(toggles, function (btn) {
    btn.addEventListener('click', function () {
      var li = btn.closest('li');
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      var open = li.classList.toggle('is-open');
      panel.classList.toggle('is-hidden', !open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });
}
```

Không làm accordion độc quyền (mở cái này đóng cái kia) — YAGNI, ba mục ngắn.

Desktop không thêm dòng JS nào.

### 5. `page-ve-ecs.php`

Section "Tầm nhìn và sứ mệnh" (`page-ve-ecs.php:99`) hiện không có `id`. Thêm `id`
cho hai khối con bên trong nó: `tam-nhin` và `su-menh`.

## Kiểm thử

Theme không có test tự động. Xác minh thủ công trên `http://ecs.test`:

1. Hover từng mục trong 3 mục → panel hiện đúng mục con của mục đó.
2. Rê chuột từ link xuống panel → panel không biến mất (cầu chuột hoạt động).
3. Tab bàn phím vào mục cha → panel mở; Tab ra khỏi mục cuối → panel đóng.
4. Thu cửa sổ dưới breakpoint `lg` → nav desktop ẩn, accordion mobile bấm mở/đóng
   được, caret xoay, `aria-expanded` đổi giá trị.
5. Tắt JS trong DevTools → dropdown desktop vẫn hover mở được.
6. Click "Hành trình phát triển" → cuộn đúng section; click "Tầm nhìn" → cuộn tới
   khối vừa thêm `id`.

Lint PHP bằng PHP của Laragon. Build SCSS bằng Live Sass Compiler (KHÔNG chạy
`npm run build:scss` — sẽ mất vendor prefix).

## Ngoài phạm vi

- Nội dung thật cho 8 mục con của "Lĩnh vực hoạt động" và "Phát triển bền vững".
- Mega-panel 3 cột dùng chung.
- Đóng dropdown bằng phím Esc trên desktop.
- Menu nhiều hơn 2 cấp.
