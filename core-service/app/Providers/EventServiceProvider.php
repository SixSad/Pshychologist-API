<?php

namespace App\Providers;

use App\Events\ChangeUserDataEvent;
use App\Events\CommentDeletingEvent;
use App\Events\CommentUpdatingEvent;
use App\Events\CommentValidatingEvent;
use App\Events\CreatedConsultationEvent;
use App\Events\CreatedNotificationEvent;
use App\Events\CreatingConsultationEvent;
use App\Events\CreatingDocumentEvent;
use App\Events\CreatingPsychologistDataEvent;
use App\Events\CreatedSupportMessageEvent;
use App\Events\CreatingUserResultEvent;
use App\Events\DeleteDocumentEvent;
use App\Events\DeletingWorkCategoryPsychologistEvent;
use App\Events\LikeCreatingEvent;
use App\Events\LikeDeletingEvent;
use App\Events\LikeValidatingEvent;
use App\Events\PostDeletingEvent;
use App\Events\PostUpdatingEvent;
use App\Events\PostValidatingEvent;
use App\Events\RetrievedConsultationEvent;
use App\Events\RetrievedScheduleEvent;
use App\Events\SavedUserEvent;
use App\Events\SavedUserResultEvent;
use App\Events\SavedPsychologistDataEvent;
use App\Events\CreatingConsultationRoomEvent;
use App\Events\SendErrorMessagesEvent;
use App\Events\UpdatedConsultationEvent;
use App\Events\UpdatingConsultationEvent;
use App\Events\UpdatingDocumentEvent;
use App\Events\UpdatingPsychologistDataEvent;
use App\Events\UpdatingScheduleEvent;
use App\Events\UpdatingUserEvent;
use App\Events\ValidatedWorkCategoryPsychologistEvent;
use App\Events\ValidatingConsultationEvent;
use App\Events\ValidatingDocumentEvent;
use App\Events\ValidatingUserEvent;
use App\Events\ValidatingWorkCategoryPsychologistEvent;
use App\Listeners\ChangeUserDataListener;
use App\Listeners\CommentDeletingListener;
use App\Listeners\CommentUpdatingListener;
use App\Listeners\CommentValidatingListener;
use App\Listeners\CreatedNotificationSendMailListener;
use App\Listeners\CreatingDocumentListener;
use App\Listeners\CreatingTimeChangeTimezoneListener;
use App\Listeners\CreatingTimeValidateListener;
use App\Listeners\DeletingWorkCategoryPsychologistListener;
use App\Listeners\LikeCreatingListener;
use App\Listeners\LikeDeletingListener;
use App\Listeners\LikeValidatingListener;
use App\Listeners\PostDeletingListener;
use App\Listeners\PostUpdatingListener;
use App\Listeners\PostValidatingListener;
use App\Listeners\RetrievedConsultationListener;
use App\Listeners\RetrievedScheduleDispatchListener;
use App\Listeners\SendErrorMessagesListener;
use App\Listeners\UpdatedConsultationListener;
use App\Listeners\UpdatingConsultationListener;
use App\Listeners\CreatedConsultationAttachRoomListener;
use App\Listeners\CreatingConsultationValidateConsultationListener;
use App\Listeners\ChangeStatusStatusChangeListener;
use App\Listeners\CreatingPsychologistDataSaveDataListener;
use App\Listeners\CreatingUserResultSaveResultTestListener;
use App\Listeners\DeleteDocumentListener;
use App\Listeners\SavedPsychologistDataSaveDocumentsListener;
use App\Listeners\SavedUserResultSaveResultTestListener;
use App\Listeners\CreatingConsultationRoomAttachAttributeListener;
use App\Listeners\UpdatingDocumentDispatchListener;
use App\Listeners\UpdatingPsychologistDataDispatchListener;
use App\Listeners\UpdatingScheduleValidateListener;
use App\Listeners\UpdatingUserDispatchListener;
use App\Listeners\ValidatedWorkCategoryPsychologistListener;
use App\Listeners\ValidatingConsultationListener;
use App\Listeners\ValidatingDocumentListener;
use App\Listeners\ValidatingUserListener;
use App\Listeners\ValidatingWorkCategoryPsychologistAttachIdListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;
use App\Events\CreatingChatEvent;
use App\Events\CreatingSupportChatEvent;
use App\Events\CreatingTimeEvent;
use App\Events\DeletedAnswerOptionEvent;
use App\Events\DeletedTimeEvent;
use App\Events\DeletingTimeEvent;
use App\Events\ValidatedChatEvent;
use App\Events\ValidatingSupportChatEvent;
use App\Listeners\CreatedSupportMessageUpdateSupportChatStatusListener;
use App\Listeners\CreatingChatOffsetModelListener;
use App\Listeners\CreatingChatUpdateModelListener;
use App\Listeners\CreatingSupportChatAddUserIdListener;
use App\Listeners\DeletedAnswerOptionClearUserResultListener;
use App\Listeners\DeletedTimeCancelConsultationListener;
use App\Listeners\DeletingTimeCheckAuthorListener;
use App\Listeners\DeletingTimeValidateListener;
use App\Listeners\ValidatedChatCheckUserRoleListener;
use App\Listeners\ValidatingSupportChatValidateListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ValidatingUserEvent::class => [
            ValidatingUserListener::class
        ],
        SavedUserEvent::class => [
            ChangeStatusStatusChangeListener::class
        ],
        CreatingUserResultEvent::class => [
            CreatingUserResultSaveResultTestListener::class
        ],
        UpdatingUserEvent::class => [
            UpdatingUserDispatchListener::class
        ],
        SavedUserResultEvent::class => [
            SavedUserResultSaveResultTestListener::class
        ],
        CreatingConsultationEvent::class => [
            CreatingConsultationValidateConsultationListener::class
        ],
        CreatedConsultationEvent::class => [
            CreatedConsultationAttachRoomListener::class
        ],
        UpdatingConsultationEvent::class => [
            UpdatingConsultationListener::class
        ],
        UpdatedConsultationEvent::class => [
            UpdatedConsultationListener::class
        ],
        RetrievedConsultationEvent::class => [
            RetrievedConsultationListener::class
        ],
        ValidatingConsultationEvent::class => [
            ValidatingConsultationListener::class
        ],
        CreatingConsultationRoomEvent::class => [
            CreatingConsultationRoomAttachAttributeListener::class
        ],
        CreatingTimeEvent::class => [
            CreatingTimeChangeTimezoneListener::class,
            CreatingTimeValidateListener::class
        ],
        DeletingTimeEvent::class => [
            DeletingTimeCheckAuthorListener::class,
            DeletingTimeValidateListener::class,
        ],
        SavedPsychologistDataEvent::class => [
            SavedPsychologistDataSaveDocumentsListener::class
        ],
        CreatingPsychologistDataEvent::class => [
            CreatingPsychologistDataSaveDataListener::class
        ],
        UpdatingPsychologistDataEvent::class => [
            UpdatingPsychologistDataDispatchListener::class
        ],
        DeletedTimeEvent::class => [
            DeletedTimeCancelConsultationListener::class
        ],
        ValidatedChatEvent::class => [
            ValidatedChatCheckUserRoleListener::class,
        ],
        CreatingChatEvent::class => [
            CreatingChatUpdateModelListener::class,
            CreatingChatOffsetModelListener::class,
        ],
        CreatingSupportChatEvent::class => [
            CreatingSupportChatAddUserIdListener::class,
        ],
        ValidatingSupportChatEvent::class => [
            ValidatingSupportChatValidateListener::class,
        ],
        DeletedAnswerOptionEvent::class => [
            DeletedAnswerOptionClearUserResultListener::class
        ],
        CreatedSupportMessageEvent::class => [
            CreatedSupportMessageUpdateSupportChatStatusListener::class,
        ],
        ValidatingDocumentEvent::class => [
            ValidatingDocumentListener::class
        ],
        CreatingDocumentEvent::class => [
            CreatingDocumentListener::class
        ],
        UpdatingDocumentEvent::class => [
            UpdatingDocumentDispatchListener::class
        ],
        DeleteDocumentEvent::class => [
            DeleteDocumentListener::class
        ],
        CreatedNotificationEvent::class => [
            CreatedNotificationSendMailListener::class
        ],
        UpdatingScheduleEvent::class => [
            UpdatingScheduleValidateListener::class
        ],
        ValidatingWorkCategoryPsychologistEvent::class => [
            ValidatingWorkCategoryPsychologistAttachIdListener::class
        ],
        ValidatedWorkCategoryPsychologistEvent::class => [
            ValidatedWorkCategoryPsychologistListener::class
        ],
        SendErrorMessagesEvent::class => [
            SendErrorMessagesListener::class
        ],
        ChangeUserDataEvent::class => [
            ChangeUserDataListener::class
        ],
        DeletingWorkCategoryPsychologistEvent::class => [
            DeletingWorkCategoryPsychologistListener::class
        ],
        RetrievedScheduleEvent::class => [
            RetrievedScheduleDispatchListener::class
        ],

        PostValidatingEvent::class => [
            PostValidatingListener::class
        ],
        PostUpdatingEvent::class => [
            PostUpdatingListener::class
        ],
        PostDeletingEvent::class => [
            PostDeletingListener::class
        ],

        CommentValidatingEvent::class => [
            CommentValidatingListener::class
        ],
        CommentUpdatingEvent::class => [
            CommentUpdatingListener::class
        ],
        CommentDeletingEvent::class => [
            CommentDeletingListener::class
        ],

        LikeValidatingEvent::class => [
            LikeValidatingListener::class
        ],
        LikeCreatingEvent::class => [
            LikeCreatingListener::class
        ],
        LikeDeletingEvent::class => [
            LikeDeletingListener::class
        ]
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
