import { Head } from '@inertiajs/react';
import Input from '@/components/atoms/input';
import SurfaceBox from '@/components/atoms/surface-box';
import { index } from '@/routes/scraper';

import ConfigBlock from './features/category';
import SavedScrapersSidebar from './features/list';

export default function Scraper() {
    return (
        <>
            <Head title="scraper" />
            <div className="m-4 flex gap-2">
                <SavedScrapersSidebar />

                <div className="block">
                    <SurfaceBox className="mb-2 flex w-2xl gap-0.5">
                        <span className="text-xs">Base URL:</span>
                        <Input value="https://th-pettersson.com/" />
                    </SurfaceBox>
                    <div className="flex h-full flex-1 flex-col gap-2 overflow-x-auto rounded-xl p-4">
                        <div className="grid auto-rows-min gap-2 md:grid-cols-4">
                            <ConfigBlock />
                            <ConfigBlock />
                            <ConfigBlock />
                            <ConfigBlock />
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Scraper.layout = {
    breadcrumbs: [
        {
            title: 'Scraper',
            href: index(),
        },
    ],
};
