// --- LOGIC CHO SLIDER MOVIE LISTS ---
const iconsBefore = document.querySelectorAll(".iconbefore");
const movieLists = document.querySelectorAll(
  ".movie-list-container-listwrapper-list"
);

iconsBefore.forEach((icon, i) => {
  const movieList = movieLists[i];
  
  // Khoảng cách mỗi lần trượt (bạn có thể thay đổi giá trị này)
  const slideDistance = 300; 
  
  // Biến để lưu vị trí hiện tại của slider
  let currentTranslateX = 0;

  // Tính toán số lần click tối đa
  const items = movieList.querySelectorAll(".movie-list-container-list");
  if (items.length === 0) return; // Bỏ qua nếu không có item nào

  const itemWidth = items[0].offsetWidth + 24; // 200px width + 12px margin-left + 12px margin-right
  const containerWidth = movieList.parentElement.offsetWidth;
  const maxClicks = Math.max(0, items.length - Math.floor(containerWidth / itemWidth));
  let clickCounter = 0;

  icon.addEventListener("click", () => {
    if (clickCounter < maxClicks) {
      clickCounter++;
      // Cập nhật vị trí bằng cách trừ đi khoảng cách trượt
      currentTranslateX -= slideDistance;
      // Gán giá trị mới cho transform
      movieList.style.transform = `translateX(${currentTranslateX}px)`;
    } else {
      // Khi trượt hết, quay về vị trí ban đầu
      currentTranslateX = 0;
      clickCounter = 0;
      movieList.style.transform = `translateX(0)`;
    }
  });
});








// Đoạn code này lắng nghe sự kiện nhấp chuột vào nút chuyển đổi giao diện

// 1. Tìm và lưu trữ phần tử nút tròn và tất cả các mục cần thay đổi giao diện
const ball = document.querySelector(".toggle-ball");
const items = document.querySelectorAll(
  ".container, .movie-list-container-text, .navbar-container, .sidebar, .left-menu-icon, .toggle, .logo-container-film, .menu-container-lists, .profile-text"
);

// 2. Thêm một trình lắng nghe sự kiện "click" vào nút tròn
ball.addEventListener("click", () => {
  // 3. Khi nút được nhấp, lặp qua từng mục trong danh sách `items`
  items.forEach((item) => {
    // 4. Thêm hoặc xóa lớp "active" khỏi mỗi mục.
    // Nếu mục đó chưa có lớp "active", nó sẽ được thêm vào.
    // Nếu mục đó đã có lớp "active", nó sẽ bị xóa đi.
    item.classList.toggle("active");
  });

  // 5. Cũng làm điều tương tự cho chính nút tròn để nó thay đổi kiểu (ví dụ: di chuyển)
  ball.classList.toggle("active");
});






// --- LOGIC CHO SLIDER MOVIE LISTS END ---
const modal = document.getElementById("myModal");
const openModalBtn = document.getElementById("openModalBtn"); // Nút mở modal
const closeButton = document.querySelector(".close-button"); // Nút đóng modal

// Mở modal khi click vào nút
if (openModalBtn) {
  openModalBtn.addEventListener("click", () => {
    modal.style.display = "block";
  });
}

// Đóng modal khi click vào nút đóng (x)
if (closeButton) {
  closeButton.addEventListener("click", () => {
    modal.style.display = "none";
  });
}

// Đóng modal khi click ra ngoài nội dung modal
window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});












// --- LOGIC CHO PROFILE DROPDOWN ---
const profileTextContainer = document.querySelector(".profile-text-container");
const profileDropdown = document.querySelector(".profile-dropdown");

if (profileTextContainer && profileDropdown) {
  profileTextContainer.addEventListener("click", (event) => {
    // Ngăn sự kiện click lan ra các phần tử cha
    event.stopPropagation(); 
    profileDropdown.classList.toggle("active");
  });
}

// Đóng dropdown khi người dùng click ra ngoài
document.addEventListener("click", () => {
  if (profileDropdown && profileDropdown.classList.contains('active')) {
    profileDropdown.classList.remove("active");
  }
});























// Logic cho dropdown thể loại
document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector('.menu-dropdown-parent');
    const dropdown = document.querySelector('.mega-dropdown');

    if (menu && dropdown) {
        menu.addEventListener('click', function(e) {
            // DÒNG QUAN TRỌNG: Ngăn trình duyệt cuộn lên đầu trang khi click vào thẻ <a>
            e.preventDefault(); 
            
            // Ngăn sự kiện click lan ra ngoài (để không bị document 'click' listener đóng ngay lập tức)
            e.stopPropagation(); 
            
            // Hiển thị hoặc ẩn dropdown
            dropdown.classList.toggle('active');
        });

        // Đóng dropdown khi click ra ngoài
        document.addEventListener('click', function(e) {
            // Chỉ đóng nếu dropdown đang mở và người dùng không click vào chính dropdown đó
            if (dropdown.classList.contains('active') && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }
});