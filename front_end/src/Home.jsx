import './App.css'
import Categories from './Categories.jsx'
import Courses from './Courses.jsx'
import { useState } from 'react'

function Home() {
  const [selectedCategory, setSelectedCategory] = useState(null);
  return (
    <>
      <div className="container mx-auto mt-16">
        <h1 className="text-3xl font-bold text-center mb-16">Course Catalogue</h1>
        <div className="gap-4 flex flex-col sm:flex-row">
          <Categories onSelectCategory={setSelectedCategory}  />
          <Courses selectedCategory={selectedCategory}/>
        </div>
      </div>
    </>
  )
}

export default Home
