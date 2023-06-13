// var preview = document.querySelector("#preview");
// const input = document.querySelector("#image");

// input.addEventListener("change", (e) => {
//     e.preventDefault();
//     if (e.target.files[0]) {
//         var fileReader = new FileReader();
//         fileReader.onload = (e) => {
//             const image = document.createElement("img");
//             const h3 = document.createElement("h3");
//             h3.innerText = "Voorbeeld van afbeelding";
//             image.src = e.target.result;
//             image.className = "img-thumbnail w-25 me-3";
//             preview.append(image);
//             preview.append(h3);
//         };

//         fileReader.readAsDataURL(input.files[0]);
//     }
// });
