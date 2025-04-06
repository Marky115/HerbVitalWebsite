<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $userIdToDelete = $_SESSION['userID'];

    function deleteUserAndComments($conn, $userId) {
        $conn->begin_transaction();
        try {
            $deleteCommentsSql = "DELETE FROM comments WHERE userID = ?";
            $deleteCommentsStmt = $conn->prepare($deleteCommentsSql);
            $deleteCommentsStmt->bind_param("s", $userId);
            $deleteCommentsStmt->execute();
            $deleteCommentsStmt->close();

            $deleteSavedListSql = "DELETE FROM savedlist WHERE userID = ?";
            $deleteSavedListStmt = $conn->prepare($deleteSavedListSql);
            $deleteSavedListStmt->bind_param("s", $userId);
            $deleteSavedListStmt->execute();
            $deleteSavedListStmt->close();

            $deleteUserSql = "DELETE FROM user WHERE userID = ?";
            $deleteUserStmt = $conn->prepare($deleteUserSql);
            $deleteUserStmt->bind_param("s", $userId);
            $deleteUserStmt->execute();
            $deleteUserStmt->close();

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }

    if (deleteUserAndComments($conn, $userIdToDelete)) {
        session_destroy();
        header("Location: index.php?message=profile_deleted");
        exit();
    } else {
        header("Location: profile.php?error=delete_failed");
        exit();
    }

} else {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>