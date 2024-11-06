<?php

function uploadMainImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/maincategory", $newName);
        $object->image = "images/maincategory/$newName";
    }
}

function uploadImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/category", $newName);
        $object->image = "images/category/$newName";
    }
}

function uploadSubImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/subcategory", $newName);
        $object->image = "images/subcategory/$newName";
    }
}

function uploadProductImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/product", $newName);
        $object->image = "images/product/$newName";
    }
}

function uploadHouseImage($request, $object, $fileName)
{
    if ($request->hasFile('house_image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/house", $newName);
        $object->house_image = "images/house/$newName";
    }
}

function uploadRoadImage($request, $object, $fileName)
{
    if ($request->hasFile('road_image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/road", $newName);
        $object->road_image = "images/road/$newName";
    }
}

function uploadMilestoneImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/milestone", $newName);
        $object->image = "images/milestone/$newName";
    }
}

function uploadCarouselImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/carousel", $newName);
        $object->image = "images/carousel/$newName";
    }
}

function uploadImageCitizen($request, $object, $fileName)
{
    if ($request->hasFile('image_citizen')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/citizenship", $newName);
        $object->image_citizen = "images/citizenship/$newName";
    }
}

function uploadImageFront($request, $object, $fileName)
{
    if ($request->hasFile('image_front')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/frontbluebook", $newName);
        $object->image_front = "images/frontbluebook/$newName";
    }
}

function uploadImageMain($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/bluebook", $newName);
        $object->image = "images/bluebook/$newName";
    }
}

function uploadYourImage($request, $object, $fileName)
{
    if ($request->hasFile('image')) {
        $file = $request->$fileName;
        $newName = time() . "." . $file->getClientOriginalExtension();
        $file->move("images/upload", $newName);
        $object->image = "images/upload/$newName";
    }
}
