/*SIDEBAR NAVIGATION*/

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
    sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
  }else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}


/*MODAL FOR ADD VENDOR*/

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";

  }
}


/*MODAL FOR VENDOR INFORMATION*/
// Open the modal and populate it with vendor information
function openModal(name, price, category, notes, link) {
  var modal = document.getElementById("vendorModal");
  var modalVendorName = document.getElementById("modalVendorName");
  var modalVendorPrice = document.getElementById("modalVendorPrice");
  var modalVendorCategory = document.getElementById("modalVendorCategory");
  var modalNotes = document.getElementById("modalNotes");
  var modalVendorLink = document.getElementById("modalVendorLink");

  modalVendorName.textContent = name;
  modalVendorPrice.textContent = "Price: RM" + price;
  modalVendorCategory.textContent = "Category: " + category;
  modalNotes.textContent = notes;
  modalVendorLink.href = link;

  modal.style.display = "block";
}

// Close the modal when the user clicks the close button (×)
var closeModalButton = document.getElementsByClassName("close")[0];
closeModalButton.onclick = function () {
  var modal = document.getElementById("vendorModal");
  modal.style.display = "none";
}

// Close the modal when the user clicks outside of it
window.onclick = function (event) {
  var modal = document.getElementById("vendorModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

    // Close the modal
function closeModal() {
  var modal = document.getElementById("vendorModal");
  modal.style.display = "none";
}



/*WINDOWS NOTIFICATION*/
function myFunction() {
  alert("Vendor Added Successfully!");
}



/*VENDOR CATEGORIES HEADER*/

// Get all the category items
var categoryItems = document.querySelectorAll(".category-item");

// Add click event listener to each category item
categoryItems.forEach(function(item) {
  item.addEventListener("click", function() {
// Remove the "active" class from all category items
    categoryItems.forEach(function(item) {
      item.classList.remove("active");
    });

// Add the "active" class to the clicked category item
    item.classList.add("active");

// Get the category name
    var category = item.innerText;

// Get all the vendor boxes
    var vendorBoxes = document.querySelectorAll(".box");

    vendorBoxes.forEach(function(box) {
      var boxCategory = box.getAttribute("data-category");
      if (category === "All" || category === boxCategory) {
        box.style.display = "block";
      } else {
        box.style.display = "none";
      }
    });
  });
});





