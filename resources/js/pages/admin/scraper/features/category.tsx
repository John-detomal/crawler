// import { Settings } from 'lucide-react';
import axios from 'axios';
import { produce } from 'immer';
import { useState } from 'react';
import { Button } from '@/components/atoms/button';
import InputLabelSection from '@/components/atoms/configSection/input-label-section';
import Label from '@/components/atoms/label';
import SurfaceBox from '@/components/atoms/surface-box';
import ParserField from '@/components/molecules/parser/parser-field';

import type { CategoryConfig, MatchConfigType } from '@/types';

const ConfigBlock = () => {
    // Local state management for form inputs & toggles

    // Options state mappings
    const [urlValue, setUrlValue] = useState('{1,1}');
    const [catNameValue, setCatNameValue] = useState('{1,2}');
    const [regexPattern, setRegexPattern] = useState(
        '%href="([^"]*)"[^>]*title="([^"]*)"%Usi',
    );

    const [categoryConfig, setCategoryConfig] = useState<CategoryConfig>({
        content: {
            container: {
                type: 'regex',
                pattern: '%nav[^>]*class="prodmeny[^>]*>.*</nav>%Usi',
                is_match_required: true,
            },
            items: {
                type: 'xpath',
                pattern: '//li',
                is_match_required: true,
            },
        },
        options: {
            fields: {
                url: {
                    value: '{1,1}',
                    is_transform: true,
                    is_match_required: true,
                },
                category_name: {
                    value: '{1,2}',
                    is_match_required: true,
                },
            },
            patterns: [
                {
                    pattern: '%href="([^"]*)"[^>]*title="([^"]*)"%Usi',
                    type: 'regex',
                },
            ],
        },
    });

    const scrapeCategory = async () => {
        try {
            const response = await axios.post('/scraper/scrape/category', {
                ...categoryConfig,
            });

            console.log(response.data);
        } catch (error) {
            if (axios.isAxiosError(error)) {
                console.error(error.response?.data);
            } else {
                console.error(error);
            }
        }
    };

    return (
        <div className="bg-surface/60 text-text-main flex w-full max-w-90 flex-col gap-4 rounded-2xl border border-primary/20 p-4 shadow-lg shadow-primary/5 backdrop-blur-md">
            {/* Header Line */}
            <div className="flex justify-between">
                <div className="flex items-center gap-2">
                    <h3 className="text-sm font-bold tracking-wider uppercase">
                        Category
                    </h3>
                </div>
                <Button label="Run" onClick={() => scrapeCategory()} />
            </div>

            {/* SECTION 1: EXTRACT (BLOCK) */}
            <div className="flex flex-col gap-2">
                <div className="flex items-center justify-between">
                    <Label label="Container" />
                </div>

                <SurfaceBox className="flex flex-col gap-2">
                    <InputLabelSection>
                        <div className="col-span-3">Type</div>
                        <div className="col-span-4">Pattern</div>
                    </InputLabelSection>

                    {/* Row 1: URL */}
                    <ParserField
                        type={categoryConfig.content.container?.type ?? 'regex'}
                        pattern={
                            categoryConfig.content.container?.pattern ?? ''
                        }
                        onTypeChange={(value) =>
                            setCategoryConfig(
                                produce((draft) => {
                                    if (!draft.content.container) {
                                        return;
                                    }

                                    draft.content.container.type = value;
                                }),
                            )
                        }
                        onPatternChange={(value) =>
                            setCategoryConfig(
                                produce((draft) => {
                                    if (!draft.content.container) {
                                        return;
                                    }

                                    draft.content.container.pattern = value;
                                }),
                            )
                        }
                    />
                </SurfaceBox>
            </div>

            {/* SECTION 2: ITEMS */}
            <div className="flex flex-col gap-2">
                <div className="flex items-center justify-between text-[11px] font-semibold tracking-wider uppercase opacity-80">
                    <span>Items</span>
                    {/* <button className="flex items-center gap-1 opacity-60 transition-opacity hover:opacity-100">
                        <span>edit condition</span>
                        <Settings className="h-3 w-3" />
                    </button> */}
                </div>

                <div className="bg-surface-nested/40 flex flex-col gap-2 rounded-xl border border-secondary/10 p-3">
                    <div className="grid grid-cols-12 px-1 text-[10px] font-medium opacity-60">
                        <div className="col-span-3">Type</div>
                        <div className="col-span-4">Pattern</div>
                    </div>
                    {/* Row 1: URL */}
                    <div className="grid grid-cols-12 items-center gap-2">
                        <select
                            value={categoryConfig.content.items.type}
                            onChange={(e) =>
                                setCategoryConfig(
                                    produce((draft) => {
                                        draft.content.items.type = e.target
                                            .value as MatchConfigType;
                                    }),
                                )
                            }
                            className="text-text-main col-span-3 rounded-lg border border-secondary/20 bg-background px-2 py-1 text-xs transition-colors focus:border-primary focus:outline-none"
                        >
                            <option value="regex">regex</option>
                            <option value="xpath">xpath</option>
                        </select>
                        <input
                            type="text"
                            value={categoryConfig.content.items.pattern}
                            onChange={(e) =>
                                setCategoryConfig(
                                    produce((draft) => {
                                        draft.content.items.pattern =
                                            e.target.value;
                                    }),
                                )
                            }
                            className="text-text-main col-span-9 w-full rounded-lg border border-secondary/20 bg-background px-2 py-1 font-mono text-xs transition-colors focus:border-primary focus:outline-none"
                        />
                    </div>
                </div>
            </div>

            {/* SECTION 3: OPTIONS */}
            <div className="flex flex-col gap-2">
                <div className="flex items-center justify-between text-[11px] font-semibold tracking-wider uppercase opacity-80">
                    <span>Options</span>
                    {/* <button className="flex items-center gap-1 opacity-60 transition-opacity hover:opacity-100">
                        <span>edit condition</span>
                        <Settings className="h-3 w-3" />
                    </button> */}
                </div>

                <div className="bg-surface-nested/40 flex flex-col gap-3 rounded-xl border border-secondary/10 p-3">
                    {/* Form Grid Labels */}
                    <div className="grid grid-cols-12 px-1 text-[10px] font-medium opacity-60">
                        <div className="col-span-2">Fields</div>
                        <div className="col-span-10">Value</div>
                    </div>

                    {/* Row 1: URL */}
                    <div className="grid grid-cols-12 items-center gap-2">
                        <div className="col-span-2 text-xs">url</div>
                        <input
                            type="text"
                            value={urlValue}
                            onChange={(e) => setUrlValue(e.target.value)}
                            className="text-text-main col-span-10 rounded-md border border-secondary/20 bg-background px-2 py-1 text-center font-mono text-xs focus:border-primary focus:outline-none"
                        />
                        {/* <div className="col-span-4 flex justify-end">
                            <label className="relative inline-flex cursor-pointer items-center">
                                <input
                                    type="checkbox"
                                    checked={urlTransform}
                                    onChange={(e) =>
                                        setUrlTransform(e.target.checked)
                                    }
                                    className="peer sr-only"
                                />
                                <div className="peer h-4 w-7 rounded-full bg-secondary/20 peer-checked:bg-primary peer-focus:outline-none after:absolute after:top-0.5 after:left-0.5 after:h-3 after:w-3 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                            </label>
                        </div> */}
                    </div>

                    {/* Row 2: Category Name */}
                    <div className="grid grid-cols-12 items-center gap-2">
                        <div className="col-span-2 text-xs">name</div>
                        <input
                            type="text"
                            value={catNameValue}
                            onChange={(e) => setCatNameValue(e.target.value)}
                            className="text-text-main col-span-10 rounded-md border border-secondary/20 bg-background px-2 py-1 text-center font-mono text-xs focus:border-primary focus:outline-none"
                        />
                        {/* <div className="col-span-4 flex justify-end">
                            <label className="relative inline-flex cursor-pointer items-center">
                                <input
                                    type="checkbox"
                                    checked={catNameTransform}
                                    onChange={(e) =>
                                        setCatNameTransform(e.target.checked)
                                    }
                                    className="peer sr-only"
                                />
                                <div className="peer h-4 w-7 rounded-full bg-secondary/20 peer-checked:bg-primary peer-focus:outline-none after:absolute after:top-[2px] after:left-[2px] after:h-3 after:w-3 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                            </label>
                        </div> */}
                    </div>

                    {/* Bottom Controls Row */}
                    <div className="mt-1 flex items-center justify-between border-t border-secondary/10 pt-2">
                        <div className="flex items-center gap-1.5">
                            <span className="text-[11px] opacity-60">
                                Rules
                            </span>
                        </div>
                        <div className="flex items-center gap-1.5">
                            <Button label="Add" />
                        </div>
                    </div>

                    {/* Inline Sub-Regex display */}
                    <div className="mt-1 flex items-center gap-1.5 rounded-lg border border-secondary/10 bg-background/50 p-2">
                        <span className="font-mono text-[10px] tracking-wider uppercase opacity-50">
                            pattern
                        </span>
                        <input
                            type="text"
                            value={regexPattern}
                            onChange={(e) => setRegexPattern(e.target.value)}
                            className="text-text-main w-full truncate bg-transparent font-mono text-[11px] focus:outline-none"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ConfigBlock;
