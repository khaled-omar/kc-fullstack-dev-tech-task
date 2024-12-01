import React from 'react'

function CourseItem({ item }) {
  return (
    <div
      className="w-full min-w-fit min-h-60 pb-2 flex flex-col rounded-md bg-white shadow hover:bg-gray-100 cursor-pointer">
      <div className="mb-5 md:w-full">
        <img src={item?.image_preview} className="object-cover rounded-md  h-full w-full" alt={item.title}/>
      </div>
      <div className="px-5">
        <h2 className="text-sm font-black ">{item.title.substring(0, 20) }</h2>
        <p
          className="text-sm text-gray-700 my-2">{item.description.substring(0, 40) + '...'}</p>
      </div>
    </div>
  )
}

export default CourseItem
