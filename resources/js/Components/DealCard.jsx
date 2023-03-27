import React from 'react';

const DealCard = ({ deal }) => {
    return (
        <div className="bg-white border dark:text-white dark:bg-gray-800 dark:border-gray-700 border-gray-300 shadow-md rounded-md overflow-hidden w-full">
            <div className="p-4">
                <h3 className="text-lg font-semibold">{deal.title}</h3>
                <p className="dark:text-slate-400 py-1">Metacritic score: {deal.metacriticScore}</p>
                <img
                    className="object-cover h-12"
                    src={deal.thumb}
                    alt={`${deal.title} thumbnail`}
                />
            </div>

            <div className="p-4">
                <div className="flex justify-between">
                    <p className="text-gray-600 dark:text-white">Before <span className='line-through'>${deal.normalPrice}</span></p>
                    <p className="text-red-600 font-semibold">Now {Math.round(deal.savings)}% OFF! ${deal.salePrice}</p>
                </div>
                <div className="flex justify-between">
                    <p className="text-gray-600 dark:text-white">Release Date</p>
                    <p className="text-gray-600 dark:text-white">{deal.releaseDate}</p>
                </div>
            </div>
            <div className="dark:text-white text-gray-500 text-sm my-2 px-4">Steam user rating: {deal.steamRatingText} ({deal.steamRatingPercent}%)</div>
            <div className="dark:text-white text-gray-500 text-sm my-2 px-4">{deal.steamRatingCount} Reviews</div>
            <div className="my-4">
                <a href={`https://www.metacritic.com/${deal.metacriticLink}`} className="dark:text-red-600 dark:hover:text-red-500 text-slate-400 px-4 rounded-md hover:text-slate-500 transition-colors duration-150">View deal</a>
            </div>
        </div>
    );
};

export default DealCard;
