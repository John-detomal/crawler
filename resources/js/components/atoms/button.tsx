import { cn } from '@/lib/utils';

export function Button({
    className,
    label,
    ...props
}: React.ComponentProps<'button'> & {
    label: string;
}) {
    return (
        <button
            className={cn(
                'group hover:bg-surface-nested/80 relative flex cursor-pointer items-center rounded-xl bg-primary px-4 py-0.5 text-sm text-white',
                className,
            )}
            {...props}
        >
            {label}
        </button>
    );
}
