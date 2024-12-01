import React, { useEffect, useState } from 'react'
import CourseItem from './CourseItem.jsx'

function Courses({ selectedCategory }) {
  const [courses, setCourses] = useState([])
  const [selectedCourse, setSelectedCourse] = useState(null)
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCourses()
  }, [selectedCategory])

  const fetchCourses = () => {

    let url = 'http://api.cc.localhost/courses';
    if (selectedCategory) {
      url += `?category_id=${selectedCategory}`; // Append category filter if selected
    }


    fetch(url)
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok')
        }
        return response.json()
      })
      .then((data) => {
        setCourses(data)
        setLoading(false);
      })
      .catch((error) => {
        console.error('Error fetching categories:', error)
        setLoading(false);
      })
  }

  const handleCourseClick = (course) => {
    setSelectedCourse(course);
  };

  const closeModal = () => {
    setSelectedCourse(null);
  };

  return (
    <div

      className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
      {!loading && courses.length === 0 && <p className="text-center text-lg font-normal">There are no courses found</p>}
      {!loading &&  courses?.map((item) => (

        <div key={item.id} onClick={() => handleCourseClick(item)}>
          <CourseItem item={item}/>
        </div>
      ))}

      {selectedCourse && (
        <div
          className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transform transition-transform duration-300">
          <div className="bg-white p-6 rounded-lg max-w-md w-full relative">

            {selectedCourse.image_preview && (
              <img
                src={selectedCourse.image_preview}
                alt={selectedCourse.title}
                className="w-full h-48 object-cover rounded-t-lg mb-4"
              />
            )}
            <h2 className="text-2xl font-bold mb-4">{selectedCourse.title}</h2>
            <p className="text-gray-700 mb-4">{selectedCourse.description}</p>
            <button
              onClick={closeModal}
              className="text-white bg-gray-700 rounded-full py-2 px-5 text-lg hover:bg-gray-900 float-end"
            >
             Close
            </button>
          </div>

        </div>
      )}

    </div>
  )
}

export default Courses
