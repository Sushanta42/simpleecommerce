<?php

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
