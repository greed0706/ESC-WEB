/**
 * Theme Options — JS cho 2 trang admin (Hero Slider, Footer Settings).
 * Chỉ được nạp trên đúng 2 trang đó (xem ecsges_options_assets() trong
 * inc/theme-options.php). KHÔNG dính dáng gì tới frontend.
 *
 * Ba việc:
 *   1. Thêm/xoá hàng lặp lại — clone <template data-repeat-template>, thay
 *      "__i__" (chỉ số hàng) và "__c__" (chỉ số cột) trong name của input.
 *   2. Kéo sắp xếp bằng jquery-ui-sortable (WP admin có sẵn). Sau khi kéo,
 *      chỉ số trong name lộn xộn nhưng KHÔNG cần đánh lại: PHP đọc mảng POST
 *      theo đúng thứ tự field xuất hiện trong form, còn sanitize callback thì
 *      append nên tự dồn lại 0..n.
 *   3. Ô chọn ảnh — mở Media Library của WordPress (wp.media).
 */
(function () {
	'use strict';

	var PICK_TITLE = 'Chọn ảnh';

	/* ---------------------------------------------------------------- */
	/**
	 * Container [data-repeat] mà một nút "+ Thêm" điều khiển.
	 *
	 * Quy ước markup: container đứng ngay TRƯỚC thẻ <p> chứa nút. Nhờ vậy nút
	 * "+ Thêm link" bên trong một cột không bị hiểu nhầm thành nút của
	 * container cột bao ngoài (closest() sẽ trả về nhầm).
	 */
	function containerFor(btn) {
		var p = btn.parentElement;
		var prev = p ? p.previousElementSibling : null;
		if (prev && prev.hasAttribute('data-repeat')) return prev;
		return btn.closest('[data-repeat]');
	}

	/** Số hàng thật (không tính <template>) trong 1 container. */
	function rowsIn(box) {
		return box.querySelectorAll(':scope > [data-repeat-row]');
	}

	/** Thêm 1 hàng vào cuối container, trả về hàng vừa thêm. */
	function addRow(box) {
		var tpl = box.querySelector(':scope > template[data-repeat-template]');
		if (!tpl) return null;

		var n = parseInt(box.getAttribute('data-repeat-next'), 10) || 0;
		box.setAttribute('data-repeat-next', n + 1);

		// Cột dùng "__c__", hàng con dùng "__i__". Một template chỉ chứa một
		// trong hai ở lớp ngoài cùng; template lồng bên trong (danh sách link
		// của cột) giữ nguyên "__i__" để lát nữa mới thay.
		var html = tpl.innerHTML.replace(/__c__/g, n).replace(/__i__/g, n);

		tpl.insertAdjacentHTML('beforebegin', html);
		var row = tpl.previousElementSibling;

		// Cột mới sinh ra chưa có link nào → tạo sẵn 1 dòng cho đỡ hụt hẫng.
		if (row) {
			var nested = row.querySelector('[data-repeat]');
			if (nested && rowsIn(nested).length === 0) addRow(nested);
			bindSortable(row);
		}
		return row;
	}

	document.addEventListener('click', function (e) {
		var add = e.target.closest('[data-repeat-add]');
		if (add) {
			e.preventDefault();
			var box = containerFor(add);
			if (box) {
				var row = addRow(box);
				if (row) {
					var first = row.querySelector('input[type="text"]');
					if (first) first.focus();
				}
			}
			return;
		}

		var remove = e.target.closest('[data-repeat-remove]');
		if (remove) {
			e.preventDefault();
			var target = remove.closest('[data-repeat-row]');
			if (target) target.remove();
		}
	});

	/* ---------------------------------------------------------------- */
	/**
	 * Kéo sắp xếp. Mỗi container khai handle riêng qua data-repeat-handle
	 * (mặc định .ecsges-row__handle) để sortable của cột và của link lồng
	 * nhau không giành nhau con trỏ.
	 */
	function bindSortable(scope) {
		if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.sortable) return;
		var $ = window.jQuery;
		$(scope).find('[data-repeat]').addBack('[data-repeat]').each(function () {
			var box = this;
			if (box.getAttribute('data-sortable-ready')) return;
			box.setAttribute('data-sortable-ready', '1');
			$(box).sortable({
				items: '> [data-repeat-row]',
				handle: box.getAttribute('data-repeat-handle') || '.ecsges-row__handle',
				axis: 'y',
				tolerance: 'pointer',
				forcePlaceholderSize: true,
				placeholder: 'ecsges-sort-placeholder'
			});
		});
	}

	/* ---------------------------------------------------------------- */
	/**
	 * Ô chọn ảnh. Lưu ID đính kèm vào input hidden, hiện ảnh xem trước.
	 */
	var frame = null;

	function openPicker(box) {
		var input = box.querySelector('[data-media-input]');
		var preview = box.querySelector('[data-media-preview]');
		if (!input || !window.wp || !window.wp.media) return;

		if (!frame) {
			frame = window.wp.media({
				title: PICK_TITLE,
				button: { text: PICK_TITLE },
				library: { type: 'image' },
				multiple: false
			});
		}
		// Mỗi lần mở lại phải gỡ handler cũ, nếu không ảnh chọn lần này sẽ ghi
		// đè luôn vào những ô đã mở trước đó.
		frame.off('select');
		frame.on('select', function () {
			var att = frame.state().get('selection').first();
			if (!att) return;
			var json = att.toJSON();
			var url = json.url;
			if (json.sizes && json.sizes.medium) url = json.sizes.medium.url;

			input.value = json.id;
			if (preview) {
				preview.classList.remove('is-empty');
				preview.textContent = '';
				// Dựng bằng DOM API thay vì innerHTML: url do Media Library trả
				// về nhưng vẫn là dữ liệu người dùng tải lên, không ghép chuỗi HTML.
				var img = document.createElement('img');
				img.src = url;
				img.alt = '';
				preview.appendChild(img);
			}
			syncMedia(box);
		});
		frame.open();
	}

	/** Đồng bộ nhãn nút + nút "Bỏ ảnh" theo việc đã có ảnh hay chưa. */
	function syncMedia(box) {
		var input = box.querySelector('[data-media-input]');
		var pick = box.querySelector('[data-media-pick]');
		var clear = box.querySelector('[data-media-clear]');
		var has = !!(input && input.value);
		if (pick) pick.textContent = has ? 'Đổi ảnh' : 'Chọn ảnh';
		if (clear) clear.classList.toggle('is-hidden', !has);
	}

	document.addEventListener('click', function (e) {
		var pick = e.target.closest('[data-media-pick]');
		if (pick) {
			e.preventDefault();
			openPicker(pick.closest('[data-media]'));
			return;
		}

		var clear = e.target.closest('[data-media-clear]');
		if (clear) {
			e.preventDefault();
			var box = clear.closest('[data-media]');
			if (!box) return;
			var input = box.querySelector('[data-media-input]');
			var preview = box.querySelector('[data-media-preview]');
			if (input) input.value = '';
			if (preview) {
				preview.innerHTML = '';
				preview.classList.add('is-empty');
			}
			syncMedia(box);
		}
	});

	/* ---------------------------------------------------------------- */
	document.addEventListener('DOMContentLoaded', function () {
		bindSortable(document);
	});
})();
