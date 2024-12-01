import React, { useEffect, useState } from 'react';

function Categories({ onSelectCategory }) {
  const [categories, setCategories] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState(null);

  useEffect(() => {
    fetchCategories();
  }, []);

  const fetchCategories = () => {
    fetch('http://api.cc.localhost/categories/')
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((data) => {
        setCategories(data);
      })
      .catch((error) => {
        console.error('Error fetching categories:', error);
      });
  };

  const handleCategoryClick = (e, item) => {
    e.preventDefault();
    setSelectedCategory(item.id);
    onSelectCategory(item.id);
  };

  const renderCategories = (categoryList) => {
    return (
      <ul className="list-none pl-4 my-1 ">
        {categoryList.map((item) => (
          <li key={item.id}>
            <span
              className={`block text-sm text-nowrap text-gray-700 cursor-pointer py-0.5 hover:text-blue-300 ${
                selectedCategory === item.id ? 'text-blue-300' : ''
              }`}
              onClick={(e) => handleCategoryClick(e, item)}
            >
              {item.name} ({item?.count_of_courses || 0})
            </span>

            {item.children && item.children.length > 0 && (
              <div className="pl-4 my-1">{renderCategories(item.children)}</div>
            )}
          </li>
        ))}
      </ul>
    );
  };

  return (
    <div className="w-full xs:w-1/2 md:1/3">
      {renderCategories(categories)}
    </div>
  );
}

export default Categories;
