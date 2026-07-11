import { useState } from 'react';
import { ButtonScraper } from '@/components/atoms/button-scraper';
const SavedScrapersSidebar = () => {
    // Mock data representing your saved scrapers list
    const [scrapers] = useState([
        {
            id: 1,
            name: 'TH Pettersson',
            status: 0,
            url: 'th-pettersson.com',
        },
        {
            id: 2,
            name: 'AutoTrader',
            status: 1,
            url: 'autotrader.com',
        },
        {
            id: 3,
            name: 'Carfax Scraper',
            status: 2,
            url: 'carfax.com',
        },
        {
            id: 4,
            name: 'Amazon Products',
            status: 2,
            url: 'amazon.com',
        },
        {
            id: 5,
            name: 'News Aggregator',
            status: 2,
            url: 'news.com',
        },
    ]);

    const [activeId, setActiveId] = useState(1);

    return (
        <aside className="bg-surface/60 text-text-main bg-surface flex h-full min-h-screen w-64 max-w-90 flex-col gap-4 rounded-2xl border border-r border-primary/20 p-4 shadow-lg shadow-primary/5 backdrop-blur-md">
            {/* Header */}
            <div className="mb-4 px-2">
                <h2 className="text-text-main text-xs font-semibold tracking-wider uppercase opacity-80">
                    Saved Scrapers
                </h2>
            </div>

            {/* Scraper List */}
            <div className="flex-1 space-y-2 overflow-y-auto pr-1">
                {scrapers.map((scraper) => {
                    const isActive = scraper.id === activeId;

                    return (
                        <ButtonScraper
                            onClick={() => setActiveId(scraper.id)}
                            key={scraper.id}
                            scraper={scraper}
                            isActive={isActive}
                        />
                    );
                })}
            </div>
        </aside>
    );
};

export default SavedScrapersSidebar;
